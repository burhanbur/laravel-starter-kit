table users {
  id uuid [pk]
  name varchar
  username varchar [unique]
  email varchar [unique]
  phone varchar
  password varchar
  email_verified_at datetime
  is_active boolean
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid
  deleted_at timestamp
}

table roles {
  id uuid [pk]
  code varchar [unique]
  name varchar // Super Admin, Admin, etc
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid
  deleted_at timestamp
}

table routes {
  id uuid [pk]
  name varchar
  method varchar
  module varhcar // group
  description text
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid
  deleted_at timestamp
}

table menus {
  id uuid [pk]
  name varchar
  icon varchar
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid
  deleted_at timestamp
}

table role_menus {
  id uuid [pk]
  parent_id uuid [ref: > role_menus.id]
  role_id uuid [ref: > roles.id]
  menu_id uuid [ref: > menus.id]
  route_id uuid [ref: > routes.id]
  sequence smallint
  is_active boolean
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table user_roles {
  role_id uuid [pk, ref: > roles.id]
  user_id uuid [pk, ref: > users.id]
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table role_permissions {
  route_id uuid [pk, ref: > routes.id]
  role_id uuid [pk, ref: > roles.id]
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table user_activities {
  id uuid [pk]
  user_id uuid [ref: > users.id]
  action varchar
  module varchar
  description text
  ip_address varchar
  user_agent text
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
}

table api_keys {
  id uuid [pk]
  name varchar
  key varchar (64) [unique]
  description text
  application varchar
  ip_whitelist json
  permissions json
  is_active boolean [default: true]
  rate_limit int [default: 60]
  last_used_at timestamp
  expires_at timestamp
  created_by uuid
  created_at timestamp [default: `CURRENT_TIMESTAMP()`]
  updated_by uuid
  updated_at timestamp [default: `CURRENT_TIMESTAMP()`]
  deleted_by uuid
  deleted_at timestamp

  indexes {
    (key) [name: 'idx_key']
    (is_active) [name: 'idx_is_active']
    (expires_at) [name: 'idx_expires_at']
  }
}

//////////////////////////////////////////////////////////////
// MASTER TABLES
//////////////////////////////////////////////////////////////
table approval_status {
  id uuid [pk]
  workflow_approval_id uuid [ref: > workflow_approvals.id]
  code varchar [note: 'e.g. PENDING, APPROVED, REJECTED']
  name varchar
  description text
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

table workflow_definitions {
  id uuid [pk]
  code varchar [unique, note: 'Unique identifier used by external systems']
  name varchar
  description text
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

table workflow_approvals {
  id uuid [pk]
  workflow_definition_id uuid [ref: > workflow_definitions.id]
  version smallint
  is_active boolean [default: true]
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime

  indexes {
    (workflow_definition_id, version)
  }
}

table approver_types {
  id uuid [pk]
  name varchar // e.g. "User", "Position"
  description text
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

//////////////////////////////////////////////////////////////
// WORKFLOW CONFIGURATION
//////////////////////////////////////////////////////////////
table workflow_approval_stages {
  id uuid [pk]
  workflow_approval_id uuid [ref: > workflow_approvals.id]
  sequence smallint // ini sequence kalau levelnya sama, contoh: approver adalah 2 manager, nah 2 managernya itu nanti valuenya sequence 1 atau 2 tapi kolom levelnya sama (misal level 2)
  level smallint // ini level dalam artian approver ke berapa
  approval_logic varchar [note: 'ALL or ANY']
  name varchar [note: 'Optional, e.g. Manager Approval']
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

table workflow_approvers {
  id uuid [pk]
  workflow_approval_stage_id uuid [ref: > workflow_approval_stages.id]
  approval_type_id uuid [ref: > approver_types.id]
  user_id uuid [default: null]
  position_id uuid [default: null]
  level smallint [note: 'Order of approval sequence'] // ini adalah urutan approvers
  is_optional boolean [default: false]
  can_delegate boolean [default: true]
  remarks text
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

table delegated_approvers {
  id uuid [pk]
  workflow_approver_id uuid [ref: > workflow_approvers.id, note: 'Delegation of specific approver config']
  start_date datetime
  end_date datetime
  is_active boolean [default: true]
  delegate_user_id uuid [default: null, note: 'user delegated to be approver']
  delegate_position_id uuid [default: null, note: 'position delegated to be approver']
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

//////////////////////////////////////////////////////////////
// WORKFLOW RUNTIME / INSTANCE DATA
//////////////////////////////////////////////////////////////

table workflow_requests {
  id uuid [pk]
  workflow_approval_id uuid [ref: > workflow_approvals.id]
  request_code varchar // unique code dari aplikasi pemohon
  request_source varchar // nama sistem asal, misal: HRIS, Finance, Procurement
  callback_url varchar [note: 'Webhook for notifying external system']
  requester_id uuid // user yang meminta approval
  current_level smallint // posisi urutan approver yang sedang aktif
  current_approval_status_id uuid [ref: > approval_status.id]
  remarks text // optional catatan umum
  signature_hash varchar [note: 'Hash to secure QR data: hash(qrcode + timestamp + user_id)']
  completed_at datetime [default: null]
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

// user waktu approve
table approvals {
  id uuid [pk]
  workflow_request_id uuid [ref: > workflow_requests.id]
  workflow_approval_stage_id uuid [ref: > workflow_approval_stages.id]
  workflow_approval_id uuid [ref: > workflow_approvals.id]
  approval_type_id uuid [ref: > approver_types.id]
  approval_status_id uuid [ref: > approval_status.id]
  user_id uuid [note: 'User who performed the approval']
  position_id uuid [note: 'Position if applicable']
  delegate_from_user_id uuid [null]
  delegate_from_position_id uuid [null]
  level smallint // ini adalah urutan approvers
  qrcode_path varchar // path qrcode
  signature_hash varchar // hash(qrcode + timestamp + user_id)
  note text
  approved_at datetime
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
  deleted_by uuid
  deleted_at datetime
}

table approval_histories {
  id uuid [pk]
  workflow_request_id uuid [ref: > workflow_requests.id]
  approval_id uuid [ref: > approvals.id, null] // optional: refer ke tabel approvals
  user_id uuid
  action varchar // "APPROVED", "REJECTED", "DELEGATED", "RECALLED", dll
  note text
  qrcode_path varchar
  signature_hash varchar
  approved_at datetime
  created_by uuid
  updated_by uuid
  created_at datetime [default: `CURRENT_TIMESTAMP`]
  updated_at datetime [default: `CURRENT_TIMESTAMP`]
}