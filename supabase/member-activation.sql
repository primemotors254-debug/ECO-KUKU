-- Eco Kuku membership activation status.
-- Admins manually confirm payment outside the website, then mark the account active.
alter table public.profiles
  add column if not exists is_active boolean not null default false,
  add column if not exists activated_at timestamptz;

grant update (is_active, activated_at) on public.profiles to authenticated;

drop policy if exists "Admins can update member activation" on public.profiles;
create policy "Admins can update member activation"
on public.profiles
for update
to authenticated
using ((auth.jwt() -> 'app_metadata' ->> 'role') = 'admin')
with check ((auth.jwt() -> 'app_metadata' ->> 'role') = 'admin');
