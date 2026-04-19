<?php
session_start();

$status = $_GET['status'] ?? '';
$message = '';

if ($status === 'order-success') {
    $message = 'Order placed successfully.';
} elseif ($status === 'contact-success') {
    $message = 'Message sent successfully.';
} elseif ($status === 'login-required') {
    $message = 'Please log in to continue.';
} elseif ($status === 'logged-out') {
    $message = 'You have been logged out.';
} elseif ($status === 'error') {
    $message = 'Something went wrong. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grace MUNEZERO Hotel</title>
    <style>
        :root {
            --bg: #eef7ff;
            --bg-soft: #f7fbff;
            --surface: rgba(255, 255, 255, 0.95);
            --surface-strong: #ffffff;
            --text: #0f3248;
            --muted: #4f6d82;
            --primary: #5db7ff;
            --primary-strong: #1f7ee3;
            --primary-soft: rgba(93, 183, 255, 0.16);
            --accent: #63d0ff;
            --line: rgba(38, 118, 195, 0.16);
            --shadow: 0 30px 80px rgba(22, 63, 107, 0.12);
            --radius-xl: 30px;
            --radius-lg: 20px;
            --radius-md: 14px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            min-height: 100vh;
            background: radial-gradient(circle at top left, rgba(93, 183, 255, 0.22), transparent 28%),
                radial-gradient(circle at right 20%, rgba(99, 208, 255, 0.14), transparent 18%),
                linear-gradient(180deg, #f8fbff 0%, var(--bg) 42%, #e8f3ff 100%);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.4), transparent 18%),
                radial-gradient(circle at 80% 15%, rgba(255, 255, 255, 0.25), transparent 16%);
            opacity: 0.85;
            z-index: -1;
        }

        .nav {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            padding: 18px 24px;
            margin: 0 auto;
            max-width: 1180px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(93, 183, 255, 0.18);
            border-radius: 999px;
            box-shadow: 0 18px 36px rgba(35, 84, 128, 0.08);
            backdrop-filter: blur(20px);
        }

        .nav a {
            color: var(--text);
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 999px;
            transition: transform 0.22s ease, color 0.22s ease, background 0.22s ease, box-shadow 0.22s ease;
        }

        .nav a:hover,
        .nav a:focus-visible {
            background: rgba(93, 183, 255, 0.14);
            color: var(--primary-strong);
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(31, 126, 208, 0.12);
        }

        .admin-link {
            margin-left: auto;
            color: #fff !important;
            background: linear-gradient(135deg, var(--primary), var(--primary-strong));
            box-shadow: 0 12px 24px rgba(31, 126, 208, 0.2);
        }

        .notice {
            margin: 22px auto 0;
            max-width: 1120px;
            padding: 16px 20px;
            border-radius: 999px;
            color: #0f4c70;
            background: rgba(99, 208, 255, 0.18);
            border: 1px solid rgba(93, 183, 255, 0.24);
            box-shadow: 0 14px 30px rgba(33, 92, 140, 0.08);
            font-weight: 600;
        }

        .hero {
            padding: 72px 18px 36px;
        }

        .container {
            width: min(1180px, calc(100% - 36px));
            margin: 0 auto;
        }

        .hero-panel {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 36px;
            align-items: center;
            padding: 40px;
            border-radius: var(--radius-xl);
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.95), rgba(235, 246, 255, 0.95));
            border: 1px solid rgba(93, 183, 255, 0.22);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .hero-panel:hover {
            transform: translateY(-1px);
            transition: transform 0.25s ease;
        }

        .hero-copy {
            position: relative;
            z-index: 1;
        }

        .hero-copy h1 {
            margin: 0 0 14px;
            font-size: clamp(2.8rem, 6vw, 5rem);
            line-height: 1;
            letter-spacing: -0.04em;
            color: #0d2a46;
        }

        .hero-copy p {
            max-width: 560px;
            margin: 0 0 20px;
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--muted);
        }

        .eyebrow {
            display: inline-flex;
            margin-bottom: 18px;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 0.78rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            background: rgba(93, 183, 255, 0.18);
            color: var(--primary-strong);
            font-weight: 700;
        }

        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 28px;
        }

        .hero-stats div {
            min-width: 140px;
            padding: 18px 20px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(93, 183, 255, 0.18);
            box-shadow: 0 12px 30px rgba(25, 77, 117, 0.06);
        }

        .hero-stats strong {
            display: block;
            font-size: 1.45rem;
            color: var(--primary-strong);
        }

        .hero-stats span {
            color: var(--muted);
            font-size: 0.95rem;
        }

        .hero-image {
            position: relative;
            min-height: 380px;
            overflow: hidden;
            border-radius: 28px;
        }

        .hero-image::before {
            content: "";
            position: absolute;
            inset: auto auto 14px -14px;
            width: 130px;
            height: 130px;
            border-radius: 28px;
            background: radial-gradient(circle, rgba(99, 208, 255, 0.9), rgba(93, 183, 255, 0.2));
            z-index: 0;
        }

        .hero-image img {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
            min-height: 380px;
            object-fit: cover;
            border-radius: 24px;
            box-shadow: 0 32px 64px rgba(19, 57, 94, 0.18);
            transition: transform 0.5s ease, filter 0.5s ease;
        }

        .hero-image:hover img {
            transform: scale(1.03) rotate(0.2deg);
            filter: saturate(1.08);
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 22px;
            padding-bottom: 42px;
        }

        .section {
            padding: 28px;
            border-radius: var(--radius-lg);
            background: var(--surface);
            border: 1px solid rgba(93, 183, 255, 0.16);
            box-shadow: var(--shadow);
            backdrop-filter: blur(12px);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .section:hover {
            transform: translateY(-2px);
            border-color: rgba(93, 183, 255, 0.24);
            box-shadow: 0 32px 70px rgba(22, 63, 107, 0.13);
        }

        .section h2 {
            margin-top: 0;
            margin-bottom: 14px;
            font-size: 1.95rem;
            color: #0f3248;
        }

        .section p {
            color: var(--muted);
            line-height: 1.8;
        }

        .about-card { grid-column: span 5; }
        .menu-card { grid-column: span 7; }
        .gallery-card { grid-column: span 12; }
        .order-card, .contact-card { grid-column: span 6; }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        th {
            padding: 0 14px 12px;
            text-align: left;
            color: var(--primary-strong);
            font-size: 0.88rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        td {
            padding: 16px 14px;
            text-align: left;
            background: rgba(238, 247, 255, 0.96);
            border-top: 1px solid rgba(93, 183, 255, 0.12);
            border-bottom: 1px solid rgba(93, 183, 255, 0.12);
            color: var(--text);
        }

        td:first-child {
            border-left: 1px solid rgba(93, 183, 255, 0.12);
            border-radius: 14px 0 0 14px;
        }

        td:last-child {
            border-right: 1px solid rgba(93, 183, 255, 0.12);
            border-radius: 0 14px 14px 0;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
        }

        .gallery a {
            display: block;
            overflow: hidden;
            border-radius: 22px;
            position: relative;
            box-shadow: 0 20px 42px rgba(19, 57, 94, 0.12);
        }

        .gallery a::after {
            content: "Book this experience";
            position: absolute;
            left: 14px;
            bottom: 14px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(17, 82, 143, 0.82);
            color: #fff;
            font-size: 0.78rem;
            letter-spacing: 0.04em;
        }

        .gallery img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
            transition: transform 0.45s ease, filter 0.45s ease;
        }

        .gallery a:hover img {
            transform: scale(1.08);
            filter: saturate(1.08) brightness(1.02);
        }

        form {
            display: grid;
            gap: 14px;
        }

        input, select, textarea {
            width: 100%;
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid rgba(93, 183, 255, 0.2);
            background: rgba(255, 255, 255, 0.96);
            color: var(--text);
            font: inherit;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
        }

        input:focus, select:focus, textarea:focus {
            border-color: rgba(31, 126, 208, 0.5);
            box-shadow: 0 0 0 4px rgba(93, 183, 255, 0.18);
            transform: translateY(-1px);
        }

        textarea {
            min-height: 140px;
            resize: vertical;
        }

        button {
            padding: 14px 20px;
            border: 0;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--primary), var(--primary-strong));
            color: #ffffff;
            font: inherit;
            font-weight: 700;
            letter-spacing: 0.04em;
            cursor: pointer;
            box-shadow: 0 18px 34px rgba(31, 126, 208, 0.24);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(31, 126, 208, 0.3);
            background: linear-gradient(135deg, #43a2ff, #1b6ed9);
        }

        @media (max-width: 900px) {
            .hero-panel {
                grid-template-columns: 1fr;
                padding: 28px;
            }

            .about-card,
            .menu-card,
            .gallery-card,
            .order-card,
            .contact-card {
                grid-column: span 12;
            }

            .admin-link {
                margin-left: 0;
            }
        }

        @media (max-width: 640px) {
            .nav {
                padding: 14px;
            }

            .nav a {
                width: 100%;
                text-align: center;
            }

            .hero {
                padding-top: 26px;
            }

            .hero-copy h1 {
                font-size: 2.5rem;
            }

            .section {
                padding: 20px;
            }

            .hero-image img {
                min-height: 280px;
            }
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="index.php">Home</a>
        <a href="index.php#about">About</a>
        <a href="index.php#menu">Menu</a>
        <a href="index.php#gallery">Gallery</a>
        <a href="index.php#order">Order</a>
        <a href="index.php#contact">Contact</a>
        <a class="admin-link" href="login.php">Admin</a>
    </div>

    <?php if ($message !== ''): ?>
        
        <div class="notice"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <div class="hero">
        <div class="container">
            <div class="hero-panel">
                <div class="hero-copy">
                    <span class="eyebrow">Luxury Stay and Dining</span>
                    <h1>Welcome to Grace munezero HOTEL</h1>
                    <p>you are most welcome, signature meals, and a warm atmosphere designed to turn every visit into a memorable experience.</p>
                    <div class="hero-stats">
                        <div>
                            <strong>5-Star</strong>
                            <span>Guest service</span>
                        </div>
                        <div>
                            <strong>24/7</strong>
                            <span>Reception support</span>
                        </div>
                        <div>
                            <strong>Fresh</strong>
                            <span>Chef-crafted menu</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="image/img1.jpg" alt="Hotel food display">
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-grid">
        <div class="section about-card" id="about">
            <h2>About Us</h2>
            <p>being successfully to our client is our mission
            </p>
        </div>

        <div class="section menu-card" id="menu">
            <h2>Menu</h2>
            <table>
                <tr><th>Item</th><th>Price</th></tr>
                <tr><td>Fish</td><td>FRW5000</td></tr>
                <tr><td>chicken burger</td><td>FRW5000</td></tr>
                <tr><td>SUSSHI</td><td>FRW 3000</td></tr>
                <tr><td>Coffee</td><td>FRW 2000</td></tr>
                <tr><td>French Fries</td><td>FRW 2500</td></tr>
                <tr><td>Beef Steak</td><td>FRW 2500</td></tr>

                

            </table>
        </div>

        <div class="section gallery-card" id="gallery">
            <h2>Gallery</h2>
            <div class="gallery">
                <a href="#order"><img src="image/img1.jpg" alt="Gallery image 1"></a>
                <a href="#order"><img src="image/img2.jpg" alt="Gallery image 2"></a>
                <a href="#order"><img src="image/img3.jpg" alt="Gallery image 3"></a>
                <a href="#order"><img src="image/img4.jpg" alt="Gallery image 4"></a>
                <a href="#order"><img src="image/img5.jpg" alt="Gallery image 5"></a>
            </div>
        </div>

        <div class="section order-card" id="order">
            <h2>Order Food</h2>
            <form action="order.php" method="post">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone" required>
                <select name="menu" required>
                    <option value="Fish">Fish</option>
                    <option value="Drink">Drink</option>
                    <option value="Fresh Juice">Fresh Juice</option>
                </select>
                <textarea name="address" placeholder="Address" required></textarea>
                <input type="date" name="date" required>
                <button type="submit">Order</button>
            </form>
        </div>

        <div class="section contact-card" id="contact">
            <h2>Contact Us</h2>
            <form action="contact.php" method="post">
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Phone" required>
                <input type="text" name="location" placeholder="Location" required>
                <textarea name="message" placeholder="Your message" required></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
        </div>
    </div>
</body>
</html>
