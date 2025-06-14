# TODO List
## Subscription

- [X] Update

## Check-in
> Create Actions for check-in

- [ ] Create
- [ ] Update
- [ ] Index or Lists
- [ ] Delete


## Member
- [ ] Edit Page


## Notes
1. Creating a member no longer requires a subscription.
2. Check-in:
    - member must be active.
    - should be able to be created without a subscription.
    - if it has a subscription, amount should be 0. (Amount is nullable)
3. Subscriptions:
    - member must be active.
    - need to only have one active subscription.
    - can be updated if customer wants to change the plan.
3. Upon visiting the members page, the system should check if the member has an active subscription, and update it accordingly.
4. Subscriptions duration 1:30 days
    - 1 duration = 30 days


## Flow
### For daily
1. Search or Create a member if not exists.
2. Check-in the member. [Always check if member is active and if it has a subscription]
 
### For Subscription based members
1. Search or Create a member if not exists.
2. Create a subscription if not exists.
   - If the member has an active subscription, update it if the customer wants to change the plan.
   - If the member does not have an active subscription, create a new one.
2. Check-in the member. [Always check if member is active and if it has a subscription]


## Notes for Developers
- After subscription update will be working on the member page FE.
