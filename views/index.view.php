<?php if (!defined('VALID_REQUEST'))
    die(); ?>

<header class="bg-primary text-white text-center py-5 mb-4">
    <div class="container">
        <h1 class="fw-bold">FlexiPHP Framework</h1>
        <p class="lead my-0">Super lightweight, fast, and easy to use for developing small-scale PHP web projects.</p>
        <p class="lead my-0">Siêu nhẹ, nhanh, dễ dùng để phát triển cho các dự án web PHP cỡ nhỏ</p>
    </div>
</header>

<main class="container">
    <section class="mb-5">
        <h2>Introduction | Giới thiệu</h2>
        <p>FlexiPHP is a super lightweight PHP framework, ideal for small web applications and rapid development. Built
            with a purely functional design and no classes, FlexiPHP offers simplicity, efficiency, and full control.
        </p>
        <p>FlexiPHP là framework PHP siêu nhẹ, lý tưởng cho các ứng dụng web nhỏ và phát triển nhanh. Với thiết kế thuần
            hàm, không dùng class, FlexiPHP mang đến sự đơn giản, hiệu quả và dễ kiểm soát.</p>
    </section>

    <section class="mb-5">
        <h2>Key Features | Tính năng chính</h2>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Simple and easy-to-understand MVC architecture</li>
                    <li class="list-group-item">Flexible routing with RESTful API support</li>
                    <li class="list-group-item">Basic session, cache, and security management</li>
                    <li class="list-group-item">Easily extensible and customizable</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Kiến trúc MVC đơn giản, dễ hiểu</li>
                    <li class="list-group-item">Hỗ trợ routing linh hoạt, thân thiện với RESTful API</li>
                    <li class="list-group-item">Quản lý session, cache, và bảo mật cơ bản</li>
                    <li class="list-group-item">Dễ dàng mở rộng và tùy biến</li>
                </ul>
            </div>
        </div>
    </section>

    <section>
        <h2>Getting Started | Bắt đầu</h2>
        <p class="my-0">Download FlexiPHP and start developing today!</p>
        <p class="mt-0 mb-3">Tải FlexiPHP và bắt đầu phát triển ngay hôm nay!</p>
        <a href="https://github.com/omnisci-lab/flexiphp" class="btn btn-primary" target="_blank" rel="noopener">GitHub
            Repository</a>
        <a href="/example/list" class="btn btn-secondary">Ví dụ 1 (Web)</a>
        <a href="/api/example/list" class="btn btn-secondary">Ví dụ 2 (WebAPI)</a>
    </section>
</main>

<footer class="bg-light text-center py-4 mt-5">
    <div class="container">
        &copy; 2025 OmniSciLab. Licensed under the MIT License. |
        <?php echo 'Peak RAM: ' . round(memory_get_peak_usage() / 1048576, 2) . ' MB'; ?>
    </div>
</footer>