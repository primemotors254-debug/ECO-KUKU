-- Run this once in the Supabase SQL Editor.
create table if not exists public.referral_display_overrides (
  member_id uuid primary key references public.profiles(id) on delete cascade,
  display_count integer not null check (display_count >= 0),
  active_display_count integer check (active_display_count is null or active_display_count >= 0),
  updated_at timestamptz not null default now()
);
alter table public.referral_display_overrides add column if not exists active_display_count integer check (active_display_count is null or active_display_count >= 0);
alter table public.referral_display_overrides enable row level security;
grant select on public.referral_display_overrides to authenticated;
grant insert, update, delete on public.referral_display_overrides to authenticated;
drop policy if exists "Members can read own referral display count" on public.referral_display_overrides;
create policy "Members can read own referral display count"
on public.referral_display_overrides for select to authenticated
using (member_id = auth.uid());
drop policy if exists "Admins can manage referral display counts" on public.referral_display_overrides;
create policy "Admins can manage referral display counts"
on public.referral_display_overrides for all to authenticated
using ((auth.jwt() -> 'app_metadata' ->> 'role') = 'admin')
with check ((auth.jwt() -> 'app_metadata' ->> 'role') = 'admin');
notify pgrst, 'reload schema';
