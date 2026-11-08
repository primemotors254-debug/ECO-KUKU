import { createClient } from "https://esm.sh/@supabase/supabase-js@2";

const corsHeaders = {
  "Access-Control-Allow-Origin": "https://ecokukufarm.com",
  "Access-Control-Allow-Headers": "authorization, x-client-info, apikey, content-type",
  "Access-Control-Allow-Methods": "POST, OPTIONS",
};

Deno.serve(async (req) => {
  if (req.method === "OPTIONS") return new Response("ok", { headers: corsHeaders });
  const json = (body: unknown, status = 200) =>
    new Response(JSON.stringify(body), { status, headers: { ...corsHeaders, "Content-Type": "application/json" } });

  if (req.method !== "POST") return json({ error: "Method not allowed." }, 405);

  const url = Deno.env.get("SUPABASE_URL");
  const anonKey = Deno.env.get("SUPABASE_ANON_KEY");
  const serviceKey = Deno.env.get("SUPABASE_SERVICE_ROLE_KEY");
  if (!url || !anonKey || !serviceKey) return json({ error: "Server configuration is incomplete." }, 500);

  const authHeader = req.headers.get("Authorization") || "";
  const token = authHeader.replace(/^Bearer\s+/i, "");
  if (!token) return json({ error: "Sign in as an administrator first." }, 401);

  const verifier = createClient(url, anonKey, { auth: { persistSession: false, autoRefreshToken: false } });
  const { data: { user }, error: authError } = await verifier.auth.getUser(token);
  if (authError || !user || user.app_metadata?.role !== "admin") {
    return json({ error: "Administrator access required." }, 403);
  }

  let email = "";
  try {
    const body = await req.json();
    email = String(body.email || "").trim().toLowerCase();
  } catch {
    return json({ error: "Invalid request." }, 400);
  }
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return json({ error: "Enter a valid member email." }, 400);

  const admin = createClient(url, serviceKey, { auth: { persistSession: false, autoRefreshToken: false } });
  const { data: found, error: findError } = await admin.auth.admin.listUsers({ page: 1, perPage: 1000 });
  if (findError) return json({ error: "Could not look up the account." }, 500);
  const target = found.users.find((u) => (u.email || "").toLowerCase() === email);
  if (!target) return json({ error: "No account was found for that email." }, 404);
  if (target.id === user.id) return json({ error: "You cannot delete the administrator account you are currently using." }, 400);
  if (target.app_metadata?.role === "admin") return json({ error: "For safety, administrator accounts cannot be deleted here." }, 400);

  const { error: referralsError } = await admin.from("referrals").delete().or(`referrer_id.eq.${target.id},referred_member_id.eq.${target.id}`);
  if (referralsError) return json({ error: "Could not remove referral records: " + referralsError.message }, 500);

  const { error: overridesError } = await admin.from("referral_display_overrides").delete().eq("member_id", target.id);
  if (overridesError) return json({ error: "Could not remove displayed referral counts: " + overridesError.message }, 500);

  const { error: profileError } = await admin.from("profiles").delete().eq("id", target.id);
  if (profileError) return json({ error: "Could not remove member profile: " + profileError.message }, 500);

  const { error: deleteError } = await admin.auth.admin.deleteUser(target.id);
  if (deleteError) return json({ error: "Profile data was removed, but the login account could not be deleted: " + deleteError.message }, 500);

  return json({ success: true, message: "Member account and associated referral data deleted. The email can now be used to register again." });
});