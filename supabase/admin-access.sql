-- Eco Kuku admin read access for the private referral dashboard.
-- Run this in Supabase SQL Editor. Then assign app_metadata.role = "admin"
-- ONLY to the owner's Auth user (instructions provided separately).
create policy "Admins can read all member profiles"
on public.profiles for select to authenticated
using ((auth.jwt() -> 'app_metadata' ->> 'role') = 'admin');

create policy "Admins can read all referrals"
on public.referrals for select to authenticated
using ((auth.jwt() -> 'app_metadata' ->> 'role') = 'admin');
