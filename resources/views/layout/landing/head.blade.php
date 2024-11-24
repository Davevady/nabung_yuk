
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }} - NabungYuk</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
    }
    
    .hero-section {
        min-height: 90vh;
        background-size: cover;
        background-position: center;
        padding-top: 80px;
    }

    .feature-card {
        transition: transform 0.3s ease;
        border: none;
        border-radius: 1rem;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .stats-box {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-image {
        max-width: 500px;
        margin: 0 auto;
    }

    .gradient-section {
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        padding: 80px 0;
        margin-bottom: 0;
    }

    .cta-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 3rem;
        margin: 2rem auto;
        max-width: 800px;
    }

    .footer-link {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-link:hover {
        color: #0d6efd;
    }

    .footer-icon {
        width: 40px;
        height: 40px;
        background: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: #0d6efd;
    }

    .btn-cta {
        padding: 12px 32px;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .btn-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .btn-cta:hover::before {
        left: 100%;
    }

    .btn-cta.btn-light {
        background: #ffffff;
        color: #0d6efd;
        border: none;
    }

    .btn-cta.btn-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        background: #f8f9fa;
    }

    .btn-cta.btn-outline-light {
        border: 2px solid #ffffff;
    }

    .btn-cta.btn-outline-light:hover {
        background: rgba(255,255,255,0.1);
        transform: translateY(-3px);
    }

    .about-feature {
        padding: 1.5rem;
        border-radius: 1rem;
        transition: all 0.3s ease;
        background: #fff;
        margin-bottom: 1.5rem;
    }

    .about-feature:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .about-icon {
        width: 60px;
        height: 60px;
        background: rgba(13, 110, 253, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
</style>