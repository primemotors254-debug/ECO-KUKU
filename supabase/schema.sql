-- Eco Kuku member accounts and referral attribution
-- Run this script in Supabase SQL Editor. No fees, commissions, wallets or payouts are implemented.

create extension if not exists pgcrypto;

create table if not exists public.profiles (
  id uuid primary key references auth.users(id) on delete cascade,
  full_name text not null default '',
  referral_code text unique not null,
  referred_by uuid references public.profiles(id) on delete set null,
  created_at timestamptz not null default now()
);

create table if not exists public.referrals (
  id uuid primary key default gen_random_uuid(),
  referrer_id uuid not null references public.profiles(id) on delete cascade,
  referred_member_id uuid not null unique references public.profiles(id) on delete cascade,
  created_at timestamptz not null default now()
);

create index if not exists referrals_referrer_id_idx on public.referrals(referrer_id);
alter table public.profiles enable row level security;
alter table public.referrals enable row level security;

drop policy if exists "Members can read their own profile" on public.profiles;
create policy "Members can read their own profile" on public.profiles
  for select to authenticated using (auth.uid() = id);
drop policy if exists "Members can update their own name" on public.profiles;
create policy "Members can update their own name" on public.profiles
  for update to authenticated using (auth.uid() = id) with check (auth.uid() = id);
drop policy if exists "Members can read referrals they invited" on public.referrals;
create policy "Members can read referrals they invited" on public.referrals
  for select to authenticated using (auth.uid() = referrer_id);

create or replace function public.create_member_profile()
returns trigger
language plpgsql
security definer
set search_path = ''
as $$
declare
  inviter uuid;
  new_code text;
begin
  if new.raw_user_meta_data ? 'referred_by_code' then
    select id into inviter from public.profiles
    where referral_code = upper(trim(new.raw_user_meta_data ->> 'referred_by_code'))
    limit 1;
  end if;

  loop
    new_code := 'EKO-' || upper(substr(replace(gen_random_uuid()::text, '-', ''), 1, 8));
    exit when not exists (select 1 from public.profiles where referral_code = new_code);
  end loop;

  insert into public.profiles(id, full_name, referral_code, referred_by)
  values (new.id, coalesce(new.raw_user_meta_data ->> 'full_name', ''), new_code, inviter);

  if inviter is not null and inviter <> new.id then
    insert into public.referrals(referrer_id, referred_member_id)
    values (inviter, new.id)
    on conflict (referred_member_id) do nothing;
  end if;
  return new;
end;
$$;

drop trigger if exists on_auth_user_created_eco_kuku on auth.users;
create trigger on_auth_user_created_eco_kuku
  after insert on auth.users
  for each row execute procedure public.create_member_profile();

-- Referral attribution is created only for a valid existing code.
-- No payment, commission, balance or payout data is collected or calculated.
