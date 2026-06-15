<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in - Google Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .google-card {
            background: white;
            border-radius: 28px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            border: 1px solid #e0e0e0;
        }
        .google-logo {
            font-size: 24px;
            font-weight: 500;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
            text-align: center;
        }
        .google-logo span:nth-child(1) { color: #4285F4; }
        .google-logo span:nth-child(2) { color: #EA4335; }
        .google-logo span:nth-child(3) { color: #FBBC05; }
        .google-logo span:nth-child(4) { color: #4285F4; }
        .google-logo span:nth-child(5) { color: #34A853; }
        .google-logo span:nth-child(6) { color: #EA4335; }
        
        .title {
            font-size: 24px;
            font-weight: 400;
            color: #1f1f1f;
            margin-bottom: 8px;
            text-align: center;
        }
        .subtitle {
            font-size: 16px;
            color: #444746;
            margin-bottom: 30px;
            text-align: center;
        }
        .account-item {
            display: flex;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid #e3e3e3;
            cursor: pointer;
            transition: background 0.2s;
            text-align: left;
            background: none;
            border-top: none;
            border-left: none;
            border-right: none;
            width: 100%;
        }
        .account-item:first-child {
            border-top: 1px solid #e3e3e3;
        }
        .account-item:hover {
            background-color: #f7f9fc;
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #198754;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            margin-right: 16px;
            font-size: 18px;
        }
        .account-details {
            flex-grow: 1;
        }
        .account-name {
            font-size: 14px;
            font-weight: 500;
            color: #1f1f1f;
            margin-bottom: 2px;
        }
        .account-email {
            font-size: 12px;
            color: #444746;
        }
        .use-other {
            color: #0b57d0;
            font-weight: 500;
            font-size: 14px;
            padding: 16px;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            transition: background 0.2s;
        }
        .use-other:hover {
            background-color: #f7f9fc;
        }
        .footer-links {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            font-size: 12px;
            color: #444746;
            padding: 0 10px;
        }
        .footer-links a {
            color: #444746;
            text-decoration: none;
            margin-left: 16px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="google-card">
        <div class="google-logo">
            <span>G</span><span>o</span><span>o</span><span>g</span><span>l</span><span>e</span>
        </div>
        <h1 class="title">Pilih akun</h1>
        <div class="subtitle">untuk melanjutkan ke Sumsel Peduli</div>
        
        <form id="googleLoginForm" action="{{ route('login.google.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="email" id="selectedEmail" value="">

            <button type="submit" class="account-item btn" onclick="selectEmail('admin@gmail.com')">
                <div class="avatar-circle" style="background-color: #1f2937;">A</div>
                <div class="account-details">
                    <div class="account-name">Admin Peduli</div>
                    <div class="account-email">admin@gmail.com</div>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </button>

            <button type="submit" class="account-item btn" onclick="selectEmail('fundraiser@gmail.com')">
                <div class="avatar-circle" style="background-color: #0d6efd;">F</div>
                <div class="account-details">
                    <div class="account-name">Sahrul Fundraiser</div>
                    <div class="account-email">fundraiser@gmail.com</div>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </button>

            <button type="submit" class="account-item btn" onclick="selectEmail('donatur@gmail.com')">
                <div class="avatar-circle" style="background-color: #198754;">D</div>
                <div class="account-details">
                    <div class="account-name">Lopi Donatur</div>
                    <div class="account-email">donatur@gmail.com</div>
                </div>
                <i class="bi bi-chevron-right text-muted"></i>
            </button>

            <button type="submit" class="use-other btn" onclick="selectEmail('new')">
                <i class="bi bi-person-plus-fill me-3"></i> Gunakan Akun Google Lain (Mock)
            </button>
        </form>
        
        <div class="footer-links">
            <span>Indonesia</span>
            <div>
                <a href="#">Bantuan</a>
                <a href="#">Privasi</a>
                <a href="#">Persyaratan</a>
            </div>
        </div>
    </div>

    <script>
        function selectEmail(email) {
            document.getElementById('selectedEmail').value = email;
        }
    </script>
</body>
</html>
