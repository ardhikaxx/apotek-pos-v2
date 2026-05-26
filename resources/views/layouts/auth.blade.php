<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek POS — @yield('title', 'Auth')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #ffffff; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .auth-side-info {
            background-color: #065f46; /* Deep Emerald */
            color: #ffffff;
            width: 45%;
            padding: 4rem;
            display: flex;
            flex-column;
            justify-content: center;
        }
        .auth-side-form {
            width: 55%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem;
            background-color: #f8fafc;
        }
        @media (max-width: 992px) {
            .auth-side-info { display: none; }
            .auth-side-form { width: 100%; padding: 2rem; }
        }
        .form-card {
            width: 100%;
            max-width: 440px;
        }
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .brand-logo i {
            color: #10b981;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }
        .btn-primary {
            background-color: #10b981;
            border: none;
            border-radius: 12px;
            padding: 0.875rem 1.5rem;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.2s;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #059669;
            transform: translateY(-1px);
        }
        .btn-primary:active {
            transform: translateY(0);
        }
        .input-icon-wrapper {
            position: relative;
        }
        .input-icon-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        .input-icon-wrapper .form-control {
            padding-left: 2.75rem;
        }
        .info-content h1 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .info-content p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 3rem;
        }
        .feature-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .feature-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-side-info">
            <div class="info-content">
                <div class="brand-logo text-white">
                    <i class="fa fa-clinic-medical"></i>
                    <span>Apotek POS</span>
                </div>
                <h1>Solusi Kesehatan Keluarga Terpercaya</h1>
                <p>Temukan berbagai kebutuhan obat-obatan dan layanan kesehatan berkualitas dengan pelayanan yang cepat dan aman.</p>
                
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa fa-pills"></i></div>
                    <div>
                        <h6 class="mb-1 fw-bold">Obat Terlengkap & Asli</h6>
                        <small class="opacity-75">Menyediakan berbagai pilihan obat-obatan dari distributor resmi dan terjamin keasliannya.</small>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa fa-file-medical"></i></div>
                    <div>
                        <h6 class="mb-1 fw-bold">Konsultasi & Resep Praktis</h6>
                        <small class="opacity-75">Kemudahan dalam penebusan resep dan layanan informasi obat oleh apoteker kami.</small>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa fa-heart"></i></div>
                    <div>
                        <h6 class="mb-1 fw-bold">Pelayanan Cepat & Ramah</h6>
                        <small class="opacity-75">Kepuasan dan kesehatan Anda adalah prioritas utama dalam setiap pelayanan kami.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-side-form">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
