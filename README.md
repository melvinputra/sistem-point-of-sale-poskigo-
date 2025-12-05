<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Projek - Landing Page POS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .header p {
            font-size: 1.2em;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px;
        }
        
        .preview-section {
            margin-bottom: 40px;
        }
        
        .preview-section h2 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        .preview-image {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        
        .preview-image:hover {
            transform: scale(1.02);
        }
        
        .description {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-top: 30px;
        }
        
        .description h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.5em;
        }
        
        .description p {
            color: #666;
            line-height: 1.8;
            font-size: 1.1em;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-card h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .footer {
            background: #2d3748;
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Preview Projek Saya</h1>
            <p>Sistem Point of Sale (POS) Modern dan Efisien</p>
        </div>
        
        <div class="content">
            <div class="preview-section">
                <h2>📸 Landing Page Preview</h2>
                <img src="./asset/lp pos.png" alt="Landing Page POS Preview" class="preview-image">
            </div>
            
            <div class="description">
                <h3>Tentang Projek Ini</h3>
                <p>
                    Ini adalah sistem Point of Sale (POS) yang dibangun dengan teknologi modern untuk membantu 
                    bisnis mengelola transaksi penjualan dengan lebih efisien. Aplikasi ini dirancang dengan 
                    antarmuka yang user-friendly dan fitur-fitur yang lengkap untuk kebutuhan bisnis retail.
                </p>
            </div>
            
            <div class="features">
                <div class="feature-card">
                    <h4>💼 Manajemen Transaksi</h4>
                    <p>Proses transaksi yang cepat dan mudah dengan interface yang intuitif</p>
                </div>
                
                <div class="feature-card">
                    <h4>📊 Laporan & Analitik</h4>
                    <p>Dashboard lengkap dengan statistik penjualan real-time</p>
                </div>
                
                <div class="feature-card">
                    <h4>🏪 Manajemen Inventory</h4>
                    <p>Kelola stok produk dengan sistem inventory yang terintegrasi</p>
                </div>
                
                <div class="feature-card">
                    <h4>👥 Multi-User</h4>
                    <p>Sistem role-based access untuk berbagai level pengguna</p>
                </div>
                
                <div class="feature-card">
                    <h4>🔒 Keamanan</h4>
                    <p>Sistem keamanan terjamin dengan enkripsi data</p>
                </div>
                
                <div class="feature-card">
                    <h4>📱 Responsive Design</h4>
                    <p>Dapat diakses dari berbagai perangkat (desktop, tablet, mobile)</p>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 - Projek POS | Built with using Laravel</p>
            <p>Untuk informasi lebih lanjut, kunjungi <a href="https://github.com/yourusername/yourrepo" target="_blank">GitHub Repository</a></p>
        </div>
    </div>
</body>
</html>
