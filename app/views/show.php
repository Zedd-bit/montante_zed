<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>User Data Grid | System Console — Modern Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<style>
:root {
  --bg: #0d0f1a;
  --panel: rgba(255, 255, 255, 0.05);
  --panel-2: rgba(255, 255, 255, 0.08);
  --accent: #4f9cff;
  --danger: #ff4d7a;
  --muted: #a0a7b3;
  --mono: system-ui, sans-serif;
}

/* base */
html, body {
  height: 100%;
  margin: 0;
  font-family: var(--mono);
  background: linear-gradient(160deg, #0d0f1a, #1a1c2b);
  color: #e3e6ee;
  -webkit-font-smoothing: antialiased;
}
body {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 28px;
}

/* container */
.terminal {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 1140px;
  border-radius: 12px;
  overflow: hidden;
  background: rgba(255, 255, 255, 0.04);
  backdrop-filter: blur(12px);
  box-shadow: 0 12px 40px rgba(0,0,0,0.4);
  border: 1px solid rgba(255,255,255,0.08);
}

/* header */
.term-head {
  display: flex;
  align-items: center;
  gap: .75rem;
  padding: 1rem 1.4rem;
  background: rgba(255, 255, 255, 0.05);
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
.window-dots {
  display: flex;
  gap: 8px;
}
.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  opacity: .9;
}
.dot.red { background: #ff5f57; }
.dot.yellow { background: #ffbd2e; }
.dot.green { background: #28c840; }
.term-title {
  margin-left: auto;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--muted);
  letter-spacing: 0.5px;
}

/* layout */
.term-body {
  display: grid;
  grid-template-columns: 1fr 640px;
  min-height: 560px;
}

/* left panel */
.left {
  padding: 20px;
  background: var(--panel);
  font-size: 13px;
  line-height: 1.55;
  border-right: 1px solid rgba(255,255,255,0.06);
}
.brand {
  display: flex;
  align-items: center;
  gap: .6rem;
  margin-bottom: 12px;
}
.badge {
  background: var(--panel-2);
  padding: .35rem .55rem;
  border-radius: 4px;
  font-weight: 700;
  font-size: .95rem;
  color: var(--accent);
}
.meta {
  color: var(--muted);
  font-size: 12px;
  margin-bottom: 12px;
}
.logbox {
  background: var(--panel-2);
  padding: 12px;
  border-radius: 6px;
  border: 1px solid rgba(255,255,255,0.05);
  max-height: 300px;
  overflow: auto;
}
.logbox pre {
  margin: 0;
  font-size: 12px;
  color: var(--muted);
}

/* right panel */
.right {
  padding: 20px;
  background: rgba(255, 255, 255, 0.02);
  display: flex;
  flex-direction: column;
}
.header-row {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
}
.hacker-title {
  color: var(--accent);
  font-size: 16px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.2px;
}
.search-form {
  margin-left: auto;
  display: flex;
  gap: 8px;
  align-items: center;
}
.search-input {
  background: var(--panel);
  border: 1px solid rgba(255,255,255,0.12);
  padding: 8px 10px;
  border-radius: 6px;
  color: #fff;
  font-family: var(--mono);
  outline: none;
}
.search-input::placeholder {
  color: rgba(255,255,255,0.3);
}
.search-btn {
  background: var(--accent);
  border: none;
  padding: 8px 14px;
  border-radius: 6px;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  transition: 0.2s;
}
.search-btn:hover {
  background: #3a82e6;
}

/* table */
.table-wrap {
  overflow: auto;
  border-radius: 6px;
  border: 1px solid rgba(255,255,255,0.05);
  background: var(--panel);
}
table {
  width: 100%;
  border-collapse: collapse;
  min-width: 560px;
  font-size: 14px;
}
thead {
  background: rgba(255,255,255,0.05);
  border-bottom: 1px solid rgba(255,255,255,0.08);
}
th, td {
  padding: 12px 14px;
  border-bottom: 1px solid rgba(255,255,255,0.04);
  text-align: left;
}
th {
  font-size: 12px;
  color: var(--accent);
  text-transform: uppercase;
  letter-spacing: 1px;
}
tbody tr:hover {
  background: rgba(255,255,255,0.04);
}
.empty-row td {
  color: rgba(255,255,255,0.3);
  text-align: center;
  padding: 28px;
}

/* actions */
.action-links a {
  color: var(--accent);
  text-decoration: none;
  font-weight: 600;
  margin: 0 4px;
}
.action-links a.delete { color: var(--danger); }
.action-links a:hover {
  text-decoration: underline;
}

/* pagination & footer */
.footer-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 16px;
}
.pagination {
  display: flex;
  gap: 6px;
  padding: 8px 12px;
  background: var(--panel);
  border-radius: 6px;
}
.page-link {
  padding: 6px 10px;
  border-radius: 4px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.05);
  color: #fff;
  cursor: pointer;
  text-decoration: none;
  font-weight: 600;
  transition: all 0.2s ease;
}
.page-link:hover {
  background: var(--accent);
  color: #fff;
}
.create-btn {
  padding: 10px 16px;
  border-radius: 6px;
  border: none;
  background: var(--accent);
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  transition: 0.2s;
}
.create-btn:hover {
  background: #3a82e6;
}

/* responsive */
@media (max-width:980px) {
  .term-body { grid-template-columns: 1fr; }
  .left { order: 2; border-right: none; border-top: 1px solid rgba(255,255,255,0.05); }
  .right { order: 1; }
  .search-form { width: 100%; }
  .footer-row { flex-direction: column; gap: 12px; }
}
</style>
</head>
<body>

<div class="terminal" role="main" aria-label="User Data Grid Terminal">
  <div class="term-head">
    <div class="window-dots">
      <div class="dot red"></div>
      <div class="dot yellow"></div>
      <div class="dot green"></div>
    </div>
    <div class="term-title">Users</div>
  </div>

  <div class="term-body">
    <div class="left" aria-hidden="true">
      <div class="brand">
        <div class="badge">0x4D · SYS</div>
        <div style="color:var(--muted);font-size:12px">v0.9.3 • secure shell</div>
      </div>

      <div class="meta">Live activity • audit trail • quick tips</div>

      <div class="logbox" id="logbox" role="log" aria-live="polite">
<pre>
<span style="color:var(--muted)">[2025-09-22 13:14]</span> user:create  id=24  by=admin
<span style="color:var(--muted)">[2025-09-21 19:02]</span> user:update  id=18  by=supervisor
<span style="color:var(--muted)">[2025-09-21 18:04]</span> user:delete  id=16  by=supervisor
</pre>
      </div>

      <div style="height:12px"></div>
      <div style="color:var(--muted);font-size:12px">Tip: Use the search box to filter by id, name or email.</div>
    </div>

    <div class="right">
      <div class="header-row">
        <div class="hacker-title">Users List</div>

        <form class="search-form" action="<?= site_url('users/show'); ?>" method="get" role="search" aria-label="Search users">
          <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
          <input class="search-input" type="text" name="q" placeholder="Search id, name, email..." value="<?= html_escape($q); ?>" />
          <button class="search-btn" type="submit">SEARCH</button>
        </form>
      </div>

      <div class="table-wrap" role="table" aria-label="Users table">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Email</th>
              <th style="width:150px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($users) && is_array($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr>
                  <td><?= html_escape($user['id']); ?></td>
                  <td><?= html_escape($user['last_name']); ?></td>
                  <td><?= html_escape($user['first_name']); ?></td>
                  <td><?= html_escape($user['email']); ?></td>
                  <td class="action-links">
                    <a href="<?= site_url('users/update/'.$user['id']); ?>">Update</a> |
                    <a class="delete" href="<?= site_url('users/delete/'.$user['id']); ?>" onclick="return confirm('Delete this record?');">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr class="empty-row"><td colspan="5">No records found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="footer-row">
        <div class="pagination" aria-label="Pagination">
          <?= isset($page) ? $page : ''; ?>
        </div>

        <div style="display:flex;gap:10px;align-items:center">
          <a class="create-btn" href="<?= site_url('users/create'); ?>">Create New Record</a>
          <a style="color:var(--muted);text-decoration:none;padding:8px 10px;border:1px dashed rgba(255,255,255,0.2);border-radius:6px" href="<?= site_url(); ?>">Dashboard</a>
        </div>
      </div>
    </div>
  </div>
  <div style="text-align:center;padding:10px;color:rgba(255,255,255,0.2);font-size:12px">— modern dashboard • console visuals —</div>
</div>
</body>
</html>
