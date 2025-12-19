<footer class="footer mt-auto py-4 bg-light">
    <div class="container">
        <div class="text-center text-muted">
            <div class="mb-2">
                © <?= date('Y'); ?> Perpustakaan Digital<br>
                <small>All rights reserved</small>
            </div>
            <div>
                <a href="#" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-dark me-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        border-top: 1px solid rgba(0,0,0,0.1);
        background: #f8f9fa !important;
    }
    
    .footer a:hover {
        color: #2c3e50 !important;
        text-decoration: underline;
    }
    
    .footer i {
        font-size: 1.2rem;
        transition: transform 0.2s;
    }
    
    .footer i:hover {
        transform: translateY(-2px);
    }
</style>