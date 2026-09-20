//////////////////////////////////////////////////////////////
// USERS, ACCESS CONTROL, AND API ACCESS
//////////////////////////////////////////////////////////////

table users {
  id uuid [pk]
  name varchar
  username varchar [unique]
  email varchar [unique]
  phone varchar
  password varchar
  email_verified_at timestamp
  is_active boolean [default: true]
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
}

table roles {
  id uuid [pk]
  code varchar [unique]
  name varchar
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
}

table routes {
  id uuid [pk]
  name varchar [unique, note: 'Laravel route name']
  method varchar
  module varchar [note: 'Route group or application module']
  description text
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
}

table menu_types {
  id bigint [pk, increment]
  name varchar
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table menus {
  id uuid [pk]
  name varchar
  icon varchar
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table role_menus {
  id uuid [pk]
  parent_id uuid [ref: > role_menus.id, null]
  role_id uuid [ref: > roles.id]
  menu_id uuid [ref: > menus.id]
  route_id uuid [ref: > routes.id, null]
  menu_type_id bigint [ref: > menu_types.id, default: 1, note: "1=Sidebar, 2=Topbar, 3=Other"]
  sequence smallint [default: 0]
  is_active boolean [default: true]
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table user_roles {
  role_id uuid [pk, ref: > roles.id]
  user_id uuid [pk, ref: > users.id]
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table role_permissions {
  route_id uuid [pk, ref: > routes.id]
  role_id uuid [pk, ref: > roles.id]
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table user_activities {
  id uuid [pk]
  user_id uuid [ref: > users.id, null]
  action varchar
  module varchar
  description text
  ip_address varchar
  user_agent text
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]

  indexes {
    (user_id, created_at)
    (module, created_at)
  }
}

table api_keys {
  id uuid [pk]
  name varchar
  key_prefix varchar [note: 'Non-secret prefix for identifying the key']
  key_hash varchar(64) [unique, note: 'SHA-256 hash of the API key; raw key is shown only once']
  description text
  application varchar
  ip_whitelist json
  permissions json
  is_active boolean [default: true]
  rate_limit int [default: 60]
  last_used_at timestamp
  expires_at timestamp
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp

  indexes {
    (key_prefix)
    (is_active)
    (expires_at)
  }
}

//////////////////////////////////////////////////////////////
// WORKFLOW MASTER AND VERSIONING
//////////////////////////////////////////////////////////////
table approval_statuses {
  id uuid [pk]
  code varchar [unique, note: 'PENDING, IN_PROGRESS, APPROVED, REJECTED, CANCELLED']
  name varchar
  description text
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
}

table workflow_definitions {
  id uuid [pk]
  code varchar [unique, note: 'Stable identifier used by external systems']
  name varchar
  description text
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
}

table workflow_approvals {
  id uuid [pk]
  workflow_definition_id uuid [ref: > workflow_definitions.id]
  version smallint
  status varchar [default: 'DRAFT', note: 'DRAFT, PUBLISHED, or RETIRED. Published versions are immutable']
  published_at timestamp
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp

  indexes {
    (workflow_definition_id, version) [unique]
    (workflow_definition_id, status)
  }
}

table approver_types {
  id uuid [pk]
  code varchar [unique, note: 'USER or POSITION']
  name varchar
  description text
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp
}

//////////////////////////////////////////////////////////////
// WORKFLOW CONFIGURATION
//////////////////////////////////////////////////////////////

table workflow_approval_stages {
  id uuid [pk]
  workflow_approval_id uuid [ref: > workflow_approvals.id]
  sequence smallint [note: 'Order of the stage within a workflow version']
  approval_logic varchar [default: 'ANY', note: 'ANY or ALL']
  name varchar [note: 'For example: Manager Approval']
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp

  indexes {
    (workflow_approval_id, sequence) [unique]
  }
}

table workflow_approvers {
  id uuid [pk]
  workflow_approval_stage_id uuid [ref: > workflow_approval_stages.id]
  approver_type_id uuid [ref: > approver_types.id]
  user_id uuid [ref: > users.id, null, note: 'Required when approver type is USER']
  position_id uuid [null, note: 'External/local position identifier; required when type is POSITION']
  is_optional boolean [default: false]
  can_delegate boolean [default: true]
  remarks text
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp

  indexes {
    (workflow_approval_stage_id, user_id) [unique]
    (workflow_approval_stage_id, position_id) [unique]
  }
}

table delegated_approvers {
  id uuid [pk]
  workflow_approver_id uuid [ref: > workflow_approvers.id]
  delegate_user_id uuid [ref: > users.id, null]
  delegate_position_id uuid [null]
  start_date timestamp
  end_date timestamp
  is_active boolean [default: true]
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp

  indexes {
    (workflow_approver_id, is_active, start_date, end_date)
  }
}

//////////////////////////////////////////////////////////////
// WORKFLOW RUNTIME / INSTANCE DATA
//////////////////////////////////////////////////////////////

table workflow_requests {
  id uuid [pk]
  workflow_approval_id uuid [ref: > workflow_approvals.id, note: 'Pinned workflow version']
  request_code varchar
  request_source varchar [note: 'For example: HRIS, Finance, Procurement']
  requester_id uuid [ref: > users.id]
  current_stage_id uuid [ref: > workflow_approval_stages.id, null]
  approval_status_id uuid [ref: > approval_statuses.id]
  callback_url varchar [note: 'Validated webhook URL for the source application']
  remarks text
  completed_at timestamp
  created_by uuid [ref: > users.id, null]
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid [ref: > users.id, null]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid [ref: > users.id, null]
  deleted_at timestamp

  indexes {
    (request_source, request_code) [unique]
    (approval_status_id, created_at)
    (current_stage_id)
  }
}

// One immutable decision for an assigned approver in a workflow request.
table approvals {
  id uuid [pk]
  workflow_request_id uuid [ref: > workflow_requests.id]
  workflow_approval_stage_id uuid [ref: > workflow_approval_stages.id]
  workflow_approver_id uuid [ref: > workflow_approvers.id]
  delegated_approver_id uuid [ref: > delegated_approvers.id, null]
  actor_user_id uuid [ref: > users.id, note: 'User who performed the decision']
  actor_position_id uuid [null]
  decision varchar [note: 'APPROVED or REJECTED']
  note text
  qrcode_path varchar
  signature_hash varchar [note: 'HMAC of canonical approval data using a server secret']
  signature_key_version smallint [default: 1]
  acted_at timestamp
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]

  indexes {
    (workflow_request_id, workflow_approver_id) [unique]
    (workflow_request_id, workflow_approval_stage_id)
    (actor_user_id, acted_at)
  }
}

// Append-only audit events; corrections are recorded as new events.
table approval_histories {
  id uuid [pk]
  workflow_request_id uuid [ref: > workflow_requests.id]
  approval_id uuid [ref: > approvals.id, null]
  actor_user_id uuid [ref: > users.id, null]
  action varchar [note: 'SUBMITTED, APPROVED, REJECTED, DELEGATED, RECALLED, CANCELLED, COMPLETED']
  note text
  metadata json [note: 'Optional context such as delegation or callback result']
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]

  indexes {
    (workflow_request_id, created_at)
    (actor_user_id, created_at)
  }
}