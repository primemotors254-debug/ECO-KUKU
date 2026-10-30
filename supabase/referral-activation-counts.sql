-- Safely return activation totals for the signed-in member's own referrals only.
create or replace function public.get_my_referral_activation_counts()
returns table(total_referred bigint, active_referred bigint, pending_referred bigint)
language sql
stable
security definer
set search_path = ''
as $$
  select
    count(*)::bigint as total_referred,
    count(*) filter (where p.is_active is true)::bigint as active_referred,
    count(*) filter (where coalesce(p.is_active, false) is false)::bigint as pending_referred
  from public.referrals r
  join public.profiles p on p.id = r.referred_member_id
  where r.referrer_id = auth.uid();
$$;

revoke all on function public.get_my_referral_activation_counts() from public;
grant execute on function public.get_my_referral_activation_counts() to authenticated;
