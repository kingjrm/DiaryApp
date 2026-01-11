<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Diary App'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800;900&family=Pixelify+Sans:wght@400;500;600;700&family=Dancing+Script:wght@400;500;600;700&family=Caveat:wght@400;500;600;700&family=Kalam:wght@300;400;700&family=Shadows+Into+Light&family=Amatic+SC:wght@400;700&family=Permanent+Marker&family=Fredoka+One&family=Comfortaa:wght@300;400;500;600;700&family=Nunito:wght@200;300;400;500;600;700;800;900&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.18); }
        .neumorphism { box-shadow: 8px 8px 16px #d1d9e6, -8px -8px 16px #ffffff; }
        .neumorphism-inset { box-shadow: inset 8px 8px 16px #d1d9e6, inset -8px -8px 16px #ffffff; }
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .slide-in { animation: slideIn 0.3s ease-out; }
        @keyframes slideIn { from { transform: translateX(-100%); } to { transform: translateX(0); } }

        /* Scrapbook Styles */
        .scrapbook-paper {
            background: linear-gradient(135deg, #fefefe 0%, #f8f8f8 100%);
            box-shadow:
                0 0 0 1px rgba(0,0,0,0.1),
                0 2px 4px rgba(0,0,0,0.1),
                0 8px 16px rgba(0,0,0,0.05),
                inset 0 1px 0 rgba(255,255,255,0.8);
        }

        .scrapbook-tape {
            position: relative;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            border-radius: 2px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .scrapbook-tape::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #ff5252, #ff8c00);
            border-radius: 2px;
            z-index: -1;
        }

        .polaroid {
            background: white;
            padding: 12px 12px 40px 12px;
            box-shadow:
                0 4px 8px rgba(0,0,0,0.2),
                0 8px 16px rgba(0,0,0,0.1),
                inset 0 0 0 1px rgba(0,0,0,0.1);
            transform: rotate(-2deg);
            transition: transform 0.3s ease;
        }

        .polaroid:hover {
            transform: rotate(0deg) scale(1.02);
        }

        .sticker {
            animation: float 6s ease-in-out infinite;
        }

        .sticker:nth-child(2) { animation-delay: -2s; }
        .sticker:nth-child(3) { animation-delay: -4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        .page-flip {
            animation: pageFlip 0.6s ease-out;
        }

        @keyframes pageFlip {
            0% { transform: perspective(1000px) rotateY(-90deg); opacity: 0; }
            100% { transform: perspective(1000px) rotateY(0deg); opacity: 1; }
        }

        .writing-paper {
            background:
                linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px),
                linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 20px 20px;
            position: relative;
        }

        .writing-paper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent);
        }

        /* Font Classes */
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-pixelify { font-family: 'Pixelify Sans', sans-serif; }
        .font-dancing { font-family: 'Dancing Script', cursive; }
        .font-caveat { font-family: 'Caveat', cursive; }
        .font-kalam { font-family: 'Kalam', cursive; }
        .font-shadows { font-family: 'Shadows Into Light', cursive; }
        .font-amatic { font-family: 'Amatic SC', cursive; }
        .font-marker { font-family: 'Permanent Marker', cursive; }
        .font-fredoka { font-family: 'Fredoka One', cursive; }
        .font-comfortaa { font-family: 'Comfortaa', cursive; }
        .font-nunito { font-family: 'Nunito', sans-serif; }
        .font-quicksand { font-family: 'Quicksand', sans-serif; }

        /* Mood Card Styles */
        .mood-card {
            background: linear-gradient(135deg, #fff8dc 0%, #f5f5dc 100%);
            border-radius: 16px;
            box-shadow:
                0 8px 16px rgba(0,0,0,0.1),
                0 4px 8px rgba(0,0,0,0.05),
                inset 0 1px 0 rgba(255,255,255,0.8);
            position: relative;
            overflow: hidden;
        }

        .mood-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: sparkle 8s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
        }

        .tape-corner {
            position: absolute;
            width: 40px;
            height: 20px;
            background: linear-gradient(45deg, #ff6b6b, #ffa500);
            border-radius: 2px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .tape-corner.tl { top: -8px; left: -8px; transform: rotate(-45deg); }
        .tape-corner.tr { top: -8px; right: -8px; transform: rotate(45deg); }
        .tape-corner.bl { bottom: -8px; left: -8px; transform: rotate(45deg); }
        .tape-corner.br { bottom: -8px; right: -8px; transform: rotate(-45deg); }

        /* Scrapbook Grid Styles */
        .scrapbook-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
            position: relative;
        }

        .scrapbook-entry {
            position: relative;
            z-index: 1;
        }

        .scrapbook-entry:nth-child(odd) {
            margin-top: -10px;
        }

        .scrapbook-entry:nth-child(even) {
            margin-top: 10px;
        }

        .scrapbook-empty-state {
            position: relative;
            z-index: 1;
        }

        /* Line clamp utility */
        .line-clamp-4 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <?php if (isset($_SESSION['error'])): ?>
        <div id="error-toast" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div id="success-toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 fade-in">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>