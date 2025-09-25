<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Create User</title>
  <style>
    :root {
      --bg: #0a0c10;
      --panel: #1a1d24;
      --panel-dark: #13161c;
      --text: #cfd4dc;
      --heading: #ffffff;
      --muted: #8a9099;
      --blue: #3b82f6;
      --blue-dark: #2563eb;
      --radius: 8px;
      --mono: monospace;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: var(--mono);
      background: linear-gradient(180deg, #0b0d11 0%, #0f1117 100%);
      color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .main {
      width: 100%;
      max-width: 450px; /* 👈 keeps it small */
      padding: 20px;
    }

    .main h1 {
      color: var(--heading);
      font-size: 1.4rem;
      margin-bottom: 16px;
      text-align: center;
    }

    .panel {
      background: var(--panel);
      border-radius: var(--radius);
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 16px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    label {
      display: block;
      font-size: 0.9rem;
      margin-bottom: 6px;
      color: var(--muted);
    }

    input[type=text],
    input[type=email] {
      width: 100%;
      padding: 10px;
      border-radius: var(--radius);
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: var(--panel-dark);
      color: var(--heading);
      font-family: var(--mono);
      outline: none;
    }

    input:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 1px var(--blue);
    }

    .footer-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }

    .back-link {
      color: var(--muted);
      text-decoration: none;
      font-size: 0.9rem;
    }

    .back-link:hover {
      color: var(--blue);
    }

    button {
      padding: 10px 16px;
      border-radius: var(--radius);
      border: none;
      background: var(--blue);
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: var(--blue-dark);
    }
  </style>
</head>
<body>
  <div class="main">
    <h1>Create User</h1>
    <div class="panel">
      <form action="<?=site_url('users/create');?>" method="post">
        <div>
          <label for="last_name">Last Name</label>
          <input type="text" id="last_name" name="last_name" placeholder="Enter last name">
        </div>
        <div>
          <label for="first_name">First Name</label>
          <input type="text" id="first_name" name="first_name" placeholder="Enter first name">
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Enter email">
        </div>
        <div class="footer-row">
          <a href="<?=site_url('users/show');?>" class="back-link">← Dashboard</a>
          <button type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
