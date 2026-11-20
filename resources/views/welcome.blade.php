<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F5EEE3">
    <title>تطبيق نُور | حساباتك أوضح، تجارتك أهدأ</title>
    <meta name="description"
        content="نُور يساعدك على تنظيم حسابات الزبائن والفواتير والدفعات ومتابعة الديون من مكان واحد.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- ألوان المشروع الأصلية مع الاحتفاظ بأسمائها لاستخدامها عند الحاجة -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#F5EEE3',
                        paper: '#FFFBF5',
                        sand: '#E8DCC8',
                        appborder: '#E2D3BC',
                        inputBorder: '#DCCBB2',
                        appdivider: '#EFE4D2',
                        latte: '#C9A57B',
                        caramel: '#B07A45',
                        appbrown: '#7A4A2A',
                        espresso: '#3A2415',
                        espressoSoft: '#46291A',
                        ink: '#2A1A10',
                        appmuted: '#766050',
                        mutedIcon: '#9A8470',
                    },
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif']
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(58, 36, 21, 0.05)',
                        'warm': '0 12px 30px -4px rgba(122, 74, 42, 0.12), 0 4px 10px -2px rgba(58, 36, 21, 0.04)',
                        'warm-lg': '0 25px 50px -12px rgba(122, 74, 42, 0.22)',
                        'floating': '0 20px 40px -10px rgba(58, 36, 21, 0.25)',
                    }
                }
            }
        };
    </script>

    <style>
        :root {
            color-scheme: light;
            --cream: #F5EEE3;
            --paper: #FFFBF5;
            --sand: #E8DCC8;
            --appborder: #E2D3BC;
            --inputBorder: #DCCBB2;
            --appdivider: #EFE4D2;
            --latte: #C9A57B;
            --caramel: #B07A45;
            --appbrown: #7A4A2A;
            --espresso: #3A2415;
            --espressoSoft: #46291A;
            --ink: #2A1A10;
            --appmuted: #766050;
            --mutedIcon: #9A8470;
            --radius-xl: 28px;
            --radius-lg: 20px;
            --shadow-card: 0 18px 48px rgba(58, 36, 21, .075);
            --shadow-deep: 0 28px 80px rgba(42, 26, 16, .23);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        body {
            margin: 0;
            overflow-x: hidden;
            background: var(--cream);
            color: var(--ink);
            font-family: 'Cairo', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        body,
        button,
        a {
            font-family: 'Cairo', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            color: inherit;
        }

        img {
            display: block;
            max-width: 100%;
        }

        .container {
            width: min(1160px, calc(100% - 48px));
            margin-inline: auto;
        }

        .section {
            padding-block: 108px;
            position: relative;
        }

        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--appbrown);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .section-kicker::before {
            content: '';
            width: 24px;
            height: 2px;
            background: var(--caramel);
            border-radius: 9px;
        }

        .section-heading {
            margin: 15px 0 12px;
            color: var(--espresso);
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.35;
            font-weight: 900;
            letter-spacing: -.045em;
        }

        .section-copy {
            max-width: 610px;
            margin: 0;
            color: var(--appmuted);
            font-size: 15px;
            line-height: 2;
            font-weight: 500;
        }

        .section-intro {
            margin-bottom: 48px;
        }

        .section-intro.center {
            text-align: center;
        }

        .section-intro.center .section-kicker {
            justify-content: center;
        }

        .section-intro.center .section-copy {
            margin-inline: auto;
        }

        /* Header */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(226, 211, 188, .78);
            background: rgba(255, 251, 245, .88);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .header-inner {
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            flex: 0 0 auto;
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            border-radius: 15px;
            display: grid;
            place-items: center;
            color: var(--paper);
            background: var(--espresso);
            box-shadow: 0 8px 18px rgba(58, 36, 21, .18);
        }

        .brand-mark svg {
            width: 23px;
            height: 23px;
        }

        .brand-name {
            display: block;
            color: var(--espresso);
            font-size: 22px;
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: -.04em;
        }

        .brand-caption {
            display: block;
            margin-top: 5px;
            color: var(--appmuted);
            font-size: 10px;
            font-weight: 700;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 30px;
            color: var(--appmuted);
            font-size: 13px;
            font-weight: 800;
        }

        .main-nav a {
            position: relative;
            padding-block: 8px;
            transition: color .2s ease;
        }

        .main-nav a::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 0;
            height: 2px;
            border-radius: 5px;
            background: var(--caramel);
            transition: width .25s ease;
        }

        .main-nav a:hover {
            color: var(--espresso);
        }

        .main-nav a:hover::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .admin-link {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border: 1px solid var(--appborder);
            border-radius: 12px;
            color: var(--appmuted);
            background: var(--paper);
            transition: .2s ease;
        }

        .admin-link:hover {
            color: var(--espresso);
            border-color: var(--latte);
            transform: translateY(-2px);
        }

        .admin-link svg {
            width: 17px;
            height: 17px;
        }

        .button {
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 20px;
            border: 1px solid transparent;
            border-radius: 14px;
            font-size: 13px;
            font-weight: 900;
            transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
            cursor: pointer;
        }

        .button:hover {
            transform: translateY(-3px);
        }

        .button:active {
            transform: translateY(0) scale(.98);
        }

        .button-primary {
            color: var(--paper);
            background: var(--appbrown);
            box-shadow: 0 9px 22px rgba(122, 74, 42, .2);
        }

        .button-primary:hover {
            background: var(--espresso);
            box-shadow: 0 14px 28px rgba(58, 36, 21, .2);
        }

        .button-light {
            color: var(--espresso);
            background: var(--paper);
            border-color: var(--appborder);
        }

        .button-light:hover {
            border-color: var(--latte);
            background: #fff;
        }

        .button svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
        }

        .menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            place-items: center;
            border: 1px solid var(--appborder);
            border-radius: 13px;
            background: var(--paper);
            cursor: pointer;
        }

        .menu-toggle svg {
            width: 20px;
            height: 20px;
        }

        .mobile-nav {
            display: none;
            padding: 0 0 18px;
        }

        .mobile-nav a {
            display: block;
            padding: 11px 14px;
            border-radius: 11px;
            color: var(--appmuted);
            font-size: 13px;
            font-weight: 800;
        }

        .mobile-nav a:hover {
            background: var(--cream);
            color: var(--espresso);
        }

        .mobile-nav.open {
            display: block;
        }

        /* Hero */
        .hero {
            padding: 64px 0 78px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 620px;
            height: 620px;
            top: -250px;
            left: -260px;
            border: 1px solid rgba(176, 122, 69, .17);
            border-radius: 50%;
            pointer-events: none;
            box-shadow: 0 0 0 42px rgba(176, 122, 69, .025), 0 0 0 90px rgba(176, 122, 69, .02);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.04fr .96fr;
            align-items: center;
            gap: 56px;
            position: relative;
            z-index: 1;
        }

        .hero-copy {
            padding-block: 18px;
        }

        .release-line {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 7px 13px;
            border: 1px solid var(--appborder);
            border-radius: 999px;
            background: rgba(255, 251, 245, .75);
            color: var(--appmuted);
            font-size: 11px;
            font-weight: 800;
        }

        .release-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #4d9564;
            box-shadow: 0 0 0 4px rgba(77, 149, 100, .12);
        }

        .release-line strong {
            color: var(--appbrown);
        }

        .hero-title {
            max-width: 650px;
            margin: 24px 0 17px;
            color: var(--espresso);
            font-size: clamp(42px, 5.3vw, 68px);
            line-height: 1.25;
            font-weight: 900;
            letter-spacing: -.065em;
        }

        .hero-title .accent {
            color: var(--caramel);
            position: relative;
            white-space: nowrap;
        }

        .hero-title .accent::after {
            content: '';
            position: absolute;
            right: 2px;
            bottom: 0;
            width: 92%;
            height: 8px;
            border-top: 3px solid var(--latte);
            border-radius: 50%;
            transform: rotate(-2deg);
            opacity: .85;
        }

        .hero-description {
            max-width: 540px;
            margin: 0;
            color: var(--appmuted);
            font-size: 16px;
            line-height: 2.1;
            font-weight: 500;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 29px;
        }

        .hero-actions .button {
            min-height: 58px;
            padding-inline: 22px;
        }

        .hero-actions .button-primary {
            min-width: 220px;
        }

        .hero-actions .button-light {
            min-width: 190px;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 17px;
            margin-top: 28px;
            padding-top: 21px;
            border-top: 1px solid var(--appborder);
        }

        .hero-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--appmuted);
            font-size: 11px;
            font-weight: 800;
        }

        .hero-meta-item svg {
            width: 16px;
            height: 16px;
            color: var(--caramel);
        }

        /* Hero app preview */
        .hero-visual {
            min-height: 570px;
            position: relative;
            display: grid;
            place-items: center;
        }

        .visual-backdrop {
            position: absolute;
            width: min(440px, 94%);
            height: 440px;
            border-radius: 44% 56% 53% 47% / 47% 42% 58% 53%;
            background: linear-gradient(145deg, #E8DCC8 0%, #D7B995 100%);
            transform: rotate(-8deg);
        }

        .visual-ring {
            position: absolute;
            width: 490px;
            height: 490px;
            border: 1px solid rgba(122, 74, 42, .2);
            border-radius: 50%;
        }

        .visual-ring::before,
        .visual-ring::after {
            content: '';
            position: absolute;
            border: 1px solid rgba(122, 74, 42, .13);
            border-radius: 50%;
            inset: 24px;
        }

        .visual-ring::after {
            inset: 49px;
        }

        .hero-device {
            position: relative;
            z-index: 2;
            width: 285px;
            height: 545px;
            padding: 9px;
            border: 7px solid var(--espresso);
            border-radius: 43px;
            background: var(--espresso);
            box-shadow: var(--shadow-deep), 0 0 0 1px rgba(255, 251, 245, .75);
            transform: rotate(-4deg);
            overflow: hidden;
        }

        .device-screen {
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 29px;
            background: var(--cream);
        }

        .device-camera {
            position: absolute;
            z-index: 5;
            top: 8px;
            left: 50%;
            width: 83px;
            height: 19px;
            transform: translateX(-50%);
            border-radius: 20px;
            background: var(--espresso);
        }

        .device-screen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        .preview-ui {
            min-height: 100%;
            padding: 44px 14px 18px;
            background: #F7F0E6;
        }

        .preview-top {
            padding: 16px;
            border-radius: 19px;
            color: var(--paper);
            background: var(--espresso);
        }

        .preview-top small {
            display: block;
            color: var(--latte);
            font-size: 9px;
        }

        .preview-top strong {
            display: block;
            margin-top: 3px;
            font-size: 13px;
        }

        .preview-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 18px 2px 9px;
            color: var(--espresso);
            font-size: 11px;
            font-weight: 900;
        }

        .preview-heading span {
            color: var(--appmuted);
            font-size: 9px;
            font-weight: 700;
        }

        .preview-balance {
            padding: 15px;
            border: 1px solid var(--appborder);
            border-radius: 17px;
            background: var(--paper);
        }

        .preview-balance small {
            color: var(--appmuted);
            font-size: 9px;
            font-weight: 700;
        }

        .preview-balance strong {
            display: block;
            margin-top: 4px;
            color: var(--espresso);
            font-size: 23px;
            font-weight: 900;
        }

        .preview-balance strong em {
            color: var(--caramel);
            font-size: 10px;
            font-style: normal;
        }

        .preview-balance-foot {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            padding-top: 9px;
            margin-top: 8px;
            border-top: 1px solid var(--appdivider);
            color: var(--appmuted);
            font-size: 8px;
        }

        .preview-list {
            display: grid;
            gap: 8px;
        }

        .preview-person {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 11px 10px;
            border: 1px solid var(--appborder);
            border-radius: 13px;
            background: var(--paper);
        }

        .preview-person-info {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .preview-avatar {
            width: 29px;
            height: 29px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            color: var(--appbrown);
            background: var(--sand);
            font-size: 10px;
            font-weight: 900;
        }

        .preview-person strong {
            display: block;
            color: var(--espresso);
            font-size: 9px;
        }

        .preview-person small {
            display: block;
            margin-top: 1px;
            color: var(--appmuted);
            font-size: 8px;
        }

        .preview-person b {
            color: #9B503B;
            font-size: 9px;
            white-space: nowrap;
        }

        .float-note {
            position: absolute;
            z-index: 4;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: 1px solid rgba(226, 211, 188, .9);
            border-radius: 16px;
            background: rgba(255, 251, 245, .94);
            box-shadow: 0 14px 34px rgba(58, 36, 21, .13);
            backdrop-filter: blur(10px);
        }

        .float-note.note-one {
            right: -8px;
            bottom: 74px;
        }

        .float-note.note-two {
            left: -20px;
            top: 85px;
        }

        .float-icon {
            width: 35px;
            height: 35px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            color: #38734e;
            background: #E5F1E7;
        }

        .float-icon svg {
            width: 17px;
            height: 17px;
        }

        .float-note small {
            display: block;
            color: var(--appmuted);
            font-size: 9px;
            font-weight: 700;
        }

        .float-note strong {
            display: block;
            margin-top: 2px;
            color: var(--espresso);
            font-size: 11px;
            font-weight: 900;
        }

        .hero-stamp {
            position: absolute;
            z-index: 3;
            bottom: 18px;
            left: 5px;
            width: 88px;
            height: 88px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(122, 74, 42, .25);
            border-radius: 50%;
            color: var(--appbrown);
            background: rgba(255, 251, 245, .68);
            transform: rotate(-13deg);
        }

        .hero-stamp span {
            max-width: 62px;
            text-align: center;
            font-size: 10px;
            line-height: 1.55;
            font-weight: 900;
        }

        /* Highlights strip */
        .highlights {
            position: relative;
            z-index: 3;
            margin-top: -3px;
        }

        .highlights-inner {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            overflow: hidden;
            border: 1px solid var(--appborder);
            border-radius: 22px;
            background: var(--paper);
            box-shadow: var(--shadow-card);
        }

        .highlight {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 94px;
            padding: 20px 24px;
        }

        .highlight+.highlight {
            border-right: 1px solid var(--appdivider);
        }

        .highlight-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            display: grid;
            place-items: center;
            border-radius: 14px;
            color: var(--appbrown);
            background: var(--cream);
        }

        .highlight-icon svg {
            width: 20px;
            height: 20px;
        }

        .highlight strong {
            display: block;
            color: var(--espresso);
            font-size: 12px;
            font-weight: 900;
        }

        .highlight small {
            display: block;
            margin-top: 3px;
            color: var(--appmuted);
            font-size: 10px;
            font-weight: 600;
        }

        /* Features */
        .features-section {
            padding-top: 140px;
        }

        .features-layout {
            display: grid;
            grid-template-columns: .78fr 1.22fr;
            gap: 58px;
            align-items: start;
        }

        .features-aside {
            position: sticky;
            top: 122px;
        }

        .features-aside .section-heading {
            max-width: 400px;
        }

        .aside-note {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            max-width: 355px;
            margin-top: 28px;
            padding: 15px 16px;
            border-right: 3px solid var(--caramel);
            border-radius: 0 13px 13px 0;
            background: rgba(255, 251, 245, .65);
        }

        .aside-note svg {
            width: 19px;
            height: 19px;
            flex: 0 0 auto;
            color: var(--caramel);
            margin-top: 3px;
        }

        .aside-note p {
            margin: 0;
            color: var(--appmuted);
            font-size: 11px;
            line-height: 1.9;
            font-weight: 700;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .feature-card {
            min-height: 245px;
            padding: 24px 23px 20px;
            border: 1px solid var(--appborder);
            border-radius: 21px;
            background: var(--paper);
            box-shadow: 0 7px 22px rgba(58, 36, 21, .035);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(176, 122, 69, .55);
            box-shadow: var(--shadow-card);
        }

        .feature-card.feature-wide {
            grid-column: span 2;
            min-height: 190px;
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: start;
            gap: 18px;
            background: var(--espresso);
            border-color: var(--espresso);
        }

        .feature-icon {
            width: 47px;
            height: 47px;
            display: grid;
            place-items: center;
            margin-bottom: 19px;
            border-radius: 15px;
            color: var(--appbrown);
            background: var(--cream);
        }

        .feature-icon svg {
            width: 22px;
            height: 22px;
        }

        .feature-card h3 {
            margin: 0 0 8px;
            color: var(--espresso);
            font-size: 16px;
            font-weight: 900;
        }

        .feature-card p {
            margin: 0;
            color: var(--appmuted);
            font-size: 11px;
            line-height: 2;
            font-weight: 600;
        }

        .feature-card .feature-foot {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-top: 17px;
            color: var(--caramel);
            font-size: 10px;
            font-weight: 900;
        }

        .feature-card .feature-foot::before {
            content: '';
            width: 16px;
            height: 1px;
            background: currentColor;
        }

        .feature-wide .feature-icon {
            color: var(--latte);
            background: rgba(255, 251, 245, .11);
        }

        .feature-wide h3 {
            color: var(--paper);
        }

        .feature-wide p {
            max-width: 520px;
            color: rgba(255, 251, 245, .68);
        }

        .feature-wide .feature-foot {
            color: var(--latte);
        }

        /* Screens showcase */
        .screens-section {
            overflow: hidden;
            background: var(--paper);
            border-block: 1px solid var(--appborder);
        }

        .screens-section::before {
            content: '';
            position: absolute;
            width: 420px;
            height: 420px;
            left: -190px;
            top: 160px;
            border-radius: 50%;
            background: rgba(232, 220, 200, .45);
            filter: blur(3px);
        }

        .screens-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 42px;
            position: relative;
            z-index: 1;
        }

        .screens-head .section-intro {
            margin: 0;
        }

        .screens-head .section-copy {
            max-width: 470px;
        }

        .screen-workspace {
            display: grid;
            grid-template-columns: .78fr 1.22fr;
            gap: 28px;
            align-items: stretch;
            padding: 18px;
            position: relative;
            z-index: 1;
            border: 1px solid var(--appborder);
            border-radius: 29px;
            background: var(--cream);
        }

        .screen-sidebar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 18px 10px 18px 22px;
        }

        .screen-sidebar-label {
            margin-bottom: 15px;
            color: var(--mutedIcon);
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .06em;
        }

        .screen-tab-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            margin-bottom: 7px;
            border: 1px solid transparent;
            border-radius: 14px;
            color: var(--appmuted);
            background: transparent;
            text-align: right;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: .2s ease;
        }

        .screen-tab-btn .tab-symbol {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            border-radius: 11px;
            color: var(--appbrown);
            background: rgba(255, 251, 245, .75);
        }

        .screen-tab-btn .tab-symbol svg {
            width: 17px;
            height: 17px;
        }

        .screen-tab-btn:hover {
            color: var(--espresso);
            background: rgba(255, 251, 245, .7);
        }

        .screen-tab-btn.active {
            color: var(--paper);
            border-color: var(--espresso);
            background: var(--espresso);
            box-shadow: 0 10px 24px rgba(58, 36, 21, .16);
        }

        .screen-tab-btn.active .tab-symbol {
            color: var(--latte);
            background: rgba(255, 251, 245, .12);
        }

        .screen-description {
            min-height: 65px;
            margin: 17px 12px 0;
            padding-top: 15px;
            border-top: 1px solid var(--appborder);
            color: var(--appmuted);
            font-size: 11px;
            line-height: 1.9;
            font-weight: 600;
        }

        .screen-device-wrap {
            min-height: 590px;
            display: grid;
            place-items: center;
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            background: linear-gradient(145deg, #E9DDCC, #DCC8AE);
        }

        .screen-device-wrap::before {
            content: '';
            position: absolute;
            width: 370px;
            height: 370px;
            border: 1px solid rgba(122, 74, 42, .2);
            border-radius: 50%;
            box-shadow: 0 0 0 35px rgba(255, 255, 255, .12), 0 0 0 72px rgba(255, 255, 255, .08);
        }

        .showcase-device {
            width: 265px;
            height: 535px;
            position: relative;
            z-index: 2;
            padding: 8px;
            overflow: hidden;
            border: 6px solid var(--espresso);
            border-radius: 39px;
            background: var(--espresso);
            box-shadow: 0 25px 55px rgba(42, 26, 16, .31);
        }

        .showcase-screen {
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 27px;
            background: var(--cream);
        }

        .showcase-screen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        .screen-content {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .screen-fallback {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 28px;
            text-align: center;
            background: var(--cream);
        }

        .fallback-icon {
            width: 66px;
            height: 66px;
            display: grid;
            place-items: center;
            margin-bottom: 19px;
            border-radius: 22px;
            color: var(--appbrown);
            background: var(--paper);
            box-shadow: 0 10px 25px rgba(58, 36, 21, .08);
        }

        .fallback-icon svg {
            width: 29px;
            height: 29px;
        }

        .screen-fallback h4 {
            margin: 0;
            color: var(--espresso);
            font-size: 16px;
            font-weight: 900;
        }

        .screen-fallback p {
            max-width: 220px;
            margin: 8px 0 0;
            color: var(--appmuted);
            font-size: 10px;
            line-height: 1.9;
            font-weight: 600;
        }

        .screen-device-label {
            position: absolute;
            z-index: 3;
            right: 25px;
            bottom: 24px;
            color: rgba(58, 36, 21, .66);
            font-size: 10px;
            font-weight: 900;
        }

        /* How it works */
        .steps-section {
            padding-block: 110px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 17px;
            counter-reset: step;
        }

        .step-card {
            position: relative;
            min-height: 225px;
            padding: 27px 25px;
            border: 1px solid var(--appborder);
            border-radius: 22px;
            background: var(--paper);
        }

        .step-number {
            width: 47px;
            height: 47px;
            display: grid;
            place-items: center;
            margin-bottom: 21px;
            border-radius: 15px;
            color: var(--latte);
            background: var(--espresso);
            font-size: 17px;
            font-weight: 900;
        }

        .step-card:nth-child(2) .step-number {
            color: var(--paper);
            background: var(--appbrown);
        }

        .step-card:nth-child(3) .step-number {
            color: var(--espresso);
            background: var(--latte);
        }

        .step-card h3 {
            margin: 0 0 8px;
            color: var(--espresso);
            font-size: 16px;
            font-weight: 900;
        }

        .step-card p {
            margin: 0;
            color: var(--appmuted);
            font-size: 11px;
            line-height: 2;
            font-weight: 600;
        }

        .step-connector {
            position: absolute;
            left: -20px;
            top: 49px;
            width: 22px;
            border-top: 1px dashed var(--latte);
        }

        .step-card:last-child .step-connector {
            display: none;
        }

        /* Download CTA */
        .download-section {
            padding: 10px 0 112px;
        }

        .download-panel {
            position: relative;
            overflow: hidden;
            padding: 66px 60px;
            border-radius: 32px;
            color: var(--paper);
            background: var(--espresso);
            box-shadow: 0 28px 65px rgba(58, 36, 21, .19);
        }

        .download-panel::before {
            content: '';
            position: absolute;
            width: 440px;
            height: 440px;
            top: -250px;
            left: -115px;
            border: 1px solid rgba(201, 165, 123, .27);
            border-radius: 50%;
            box-shadow: 0 0 0 38px rgba(201, 165, 123, .045), 0 0 0 80px rgba(201, 165, 123, .035);
        }

        .download-panel::after {
            content: '';
            position: absolute;
            width: 310px;
            height: 310px;
            right: -155px;
            bottom: -210px;
            border-radius: 50%;
            background: rgba(176, 122, 69, .22);
            filter: blur(2px);
        }

        .download-content {
            max-width: 760px;
            margin-inline: auto;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .download-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 13px;
            border: 1px solid rgba(201, 165, 123, .35);
            border-radius: 99px;
            color: var(--latte);
            background: rgba(255, 255, 255, .055);
            font-size: 10px;
            font-weight: 800;
        }

        .download-badge span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--latte);
        }

        .download-title {
            margin: 18px 0 10px;
            color: #fffaf3;
            font-size: clamp(30px, 4.1vw, 48px);
            line-height: 1.4;
            font-weight: 900;
            letter-spacing: -.045em;
        }

        .download-copy {
            max-width: 570px;
            margin: 0 auto;
            color: rgba(255, 251, 245, .68);
            font-size: 13px;
            line-height: 2;
            font-weight: 600;
        }

        .download-button {
            min-height: 59px;
            margin-top: 27px;
            padding-inline: 25px;
            color: var(--espresso);
            background: var(--latte);
            box-shadow: 0 12px 25px rgba(0, 0, 0, .15);
        }

        .download-button:hover {
            background: #D8B88F;
        }

        .download-notes {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 39px;
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, .12);
            text-align: right;
        }

        .download-note {
            padding: 13px 14px;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 14px;
            color: rgba(255, 251, 245, .65);
            background: rgba(255, 255, 255, .045);
            font-size: 10px;
            line-height: 1.85;
            font-weight: 600;
        }

        .download-note strong {
            display: block;
            margin-bottom: 3px;
            color: var(--latte);
            font-size: 11px;
            font-weight: 900;
        }

        /* Footer + mobile sticky */
        .site-footer {
            padding: 34px 0 28px;
            border-top: 1px solid var(--appborder);
            background: var(--paper);
        }

        .footer-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 18px;
            color: var(--appmuted);
            font-size: 10px;
            font-weight: 800;
        }

        .footer-links a:hover {
            color: var(--appbrown);
        }

        .footer-copy {
            color: var(--appmuted);
            font-size: 10px;
            font-weight: 700;
            text-align: left;
        }

        .mobile-download {
            display: none;
        }

        .reveal {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity .65s ease, transform .65s ease;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 1020px) {
            .main-nav {
                gap: 17px;
            }

            .hero-grid {
                gap: 25px;
            }

            .hero-title {
                font-size: clamp(40px, 5.3vw, 58px);
            }

            .features-layout {
                grid-template-columns: .7fr 1.3fr;
                gap: 32px;
            }

            .highlight {
                padding-inline: 16px;
            }
        }

        @media (max-width: 820px) {
            .container {
                width: min(100% - 36px, 680px);
            }

            .header-inner {
                min-height: 72px;
            }

            .main-nav,
            .header-actions .admin-link {
                display: none;
            }

            .menu-toggle {
                display: grid;
            }

            .header-actions {
                margin-right: auto;
            }

            .hero {
                padding-top: 45px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .hero-copy {
                text-align: center;
            }

            .hero-description {
                margin-inline: auto;
            }

            .hero-actions,
            .hero-meta {
                justify-content: center;
            }

            .hero-visual {
                min-height: 570px;
                margin-top: 5px;
            }

            .hero-stamp {
                left: 6%;
            }

            .highlights-inner {
                grid-template-columns: repeat(2, 1fr);
            }

            .highlight:nth-child(3) {
                border-right: 0;
                border-top: 1px solid var(--appdivider);
            }

            .highlight:nth-child(4) {
                border-top: 1px solid var(--appdivider);
            }

            .features-layout {
                grid-template-columns: 1fr;
            }

            .features-aside {
                position: static;
            }

            .features-aside .section-heading {
                max-width: 600px;
            }

            .aside-note {
                max-width: 580px;
            }

            .screens-head {
                display: block;
            }

            .screens-head .section-intro {
                margin-bottom: 24px;
            }

            .screen-workspace {
                grid-template-columns: 1fr;
            }

            .screen-sidebar {
                padding: 8px;
            }

            .screen-sidebar-label {
                margin: 5px 6px 10px;
            }

            .screen-tabs-list {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
            }

            .screen-tab-btn {
                margin: 0;
                padding: 9px;
                font-size: 10px;
            }

            .screen-tab-btn .tab-symbol {
                width: 30px;
                height: 30px;
            }

            .screen-description {
                min-height: unset;
                margin: 12px 6px 5px;
            }

            .screen-device-wrap {
                min-height: 575px;
            }

            .steps-grid {
                gap: 12px;
            }

            .step-card {
                padding: 22px 18px;
            }

            .step-connector {
                display: none;
            }

            .download-panel {
                padding: 54px 28px;
            }

            .footer-main {
                flex-wrap: wrap;
            }

            .footer-copy {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 560px) {
            html {
                scroll-padding-top: 80px;
            }

            .container {
                width: calc(100% - 30px);
            }

            .section {
                padding-block: 76px;
            }

            .section-intro {
                margin-bottom: 32px;
            }

            .brand-mark {
                width: 40px;
                height: 40px;
                border-radius: 13px;
            }

            .brand-name {
                font-size: 20px;
            }

            .brand-caption {
                font-size: 9px;
            }

            .header-actions .button {
                min-height: 41px;
                padding: 9px 12px;
                font-size: 10px;
            }

            .menu-toggle {
                width: 40px;
                height: 40px;
            }

            .hero {
                padding: 38px 0 58px;
            }

            .release-line {
                font-size: 9px;
            }

            .hero-title {
                margin-top: 21px;
                font-size: clamp(37px, 10vw, 48px);
            }

            .hero-description {
                font-size: 13px;
            }

            .hero-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .hero-actions .button,
            .hero-actions .button-primary,
            .hero-actions .button-light {
                width: 100%;
                min-width: 0;
            }

            .hero-meta {
                gap: 10px 15px;
            }

            .hero-meta-item {
                font-size: 9px;
            }

            .hero-visual {
                min-height: 505px;
                margin-inline: -8px;
            }

            .visual-backdrop {
                width: 320px;
                height: 360px;
            }

            .visual-ring {
                width: 360px;
                height: 360px;
            }

            .hero-device {
                width: 245px;
                height: 475px;
                border-radius: 37px;
            }

            .device-screen {
                border-radius: 25px;
            }

            .preview-ui {
                padding: 39px 11px 13px;
            }

            .float-note {
                padding: 9px 10px;
                gap: 7px;
            }

            .float-note.note-one {
                right: -1px;
                bottom: 54px;
            }

            .float-note.note-two {
                left: -2px;
                top: 43px;
            }

            .float-icon {
                width: 29px;
                height: 29px;
            }

            .float-note strong {
                font-size: 9px;
            }

            .float-note small {
                font-size: 8px;
            }

            .hero-stamp {
                width: 67px;
                height: 67px;
                bottom: 10px;
                left: 0;
            }

            .hero-stamp span {
                font-size: 8px;
            }

            .highlights-inner {
                border-radius: 17px;
            }

            .highlight {
                min-height: 82px;
                gap: 9px;
                padding: 13px 10px;
            }

            .highlight-icon {
                width: 34px;
                height: 34px;
                border-radius: 11px;
            }

            .highlight-icon svg {
                width: 17px;
                height: 17px;
            }

            .highlight strong {
                font-size: 10px;
            }

            .highlight small {
                font-size: 8px;
            }

            .features-section {
                padding-top: 90px;
            }

            .section-heading {
                font-size: 31px;
            }

            .section-copy {
                font-size: 12px;
            }

            .features-grid {
                gap: 9px;
            }

            .feature-card {
                min-height: 230px;
                padding: 18px 14px;
                border-radius: 17px;
            }

            .feature-icon {
                width: 40px;
                height: 40px;
                margin-bottom: 14px;
                border-radius: 12px;
            }

            .feature-icon svg {
                width: 19px;
                height: 19px;
            }

            .feature-card h3 {
                font-size: 12px;
            }

            .feature-card p {
                font-size: 9px;
            }

            .feature-card .feature-foot {
                font-size: 8px;
            }

            .feature-card.feature-wide {
                min-height: unset;
                grid-template-columns: 1fr;
                gap: 0;
            }

            .feature-wide .feature-icon {
                margin-bottom: 14px;
            }

            .screen-workspace {
                padding: 10px;
                border-radius: 20px;
            }

            .screen-device-wrap {
                min-height: 500px;
                border-radius: 15px;
            }

            .showcase-device {
                width: 235px;
                height: 465px;
            }

            .screen-device-wrap::before {
                width: 280px;
                height: 280px;
            }

            .screen-tab-btn {
                gap: 7px;
            }

            .screen-tab-btn .tab-symbol {
                width: 27px;
                height: 27px;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .step-card {
                min-height: 0;
                padding: 21px;
            }

            .step-number {
                width: 40px;
                height: 40px;
                margin-bottom: 14px;
            }

            .step-card h3 {
                font-size: 14px;
            }

            .step-card p {
                font-size: 10px;
            }

            .download-section {
                padding: 0 0 85px;
            }

            .download-panel {
                padding: 43px 18px;
                border-radius: 24px;
            }

            .download-title {
                font-size: 31px;
            }

            .download-copy {
                font-size: 11px;
            }

            .download-button {
                width: 100%;
            }

            .download-notes {
                grid-template-columns: 1fr;
                gap: 7px;
                margin-top: 27px;
                padding-top: 17px;
            }

            .download-note {
                padding: 10px 12px;
            }

            .footer-main {
                justify-content: center;
                text-align: center;
            }

            .footer-main>.brand {
                justify-content: center;
            }

            .footer-links {
                justify-content: center;
                gap: 13px;
            }

            .site-footer {
                padding-bottom: 95px;
            }

            .mobile-download {
                display: block;
                position: fixed;
                z-index: 90;
                right: 12px;
                left: 12px;
                bottom: 12px;
                padding: 7px;
                border: 1px solid rgba(255, 255, 255, .22);
                border-radius: 17px;
                background: rgba(58, 36, 21, .95);
                box-shadow: 0 15px 38px rgba(42, 26, 16, .27);
                backdrop-filter: blur(12px);
            }

            .mobile-download a {
                min-height: 49px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 5px 10px;
                color: var(--paper);
            }

            .mobile-download-copy {
                display: flex;
                align-items: center;
                gap: 9px;
            }

            .mobile-download-icon {
                width: 33px;
                height: 33px;
                display: grid;
                place-items: center;
                border-radius: 10px;
                color: var(--espresso);
                background: var(--latte);
            }

            .mobile-download-icon svg {
                width: 17px;
                height: 17px;
            }

            .mobile-download strong {
                display: block;
                font-size: 10px;
                font-weight: 900;
            }

            .mobile-download small {
                display: block;
                margin-top: 1px;
                color: var(--sand);
                font-size: 8px;
            }

            .mobile-download-tag {
                padding: 7px 11px;
                border-radius: 9px;
                color: var(--espresso);
                background: var(--latte);
                font-size: 9px;
                font-weight: 900;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ url('/') }}" class="brand" aria-label="العودة إلى الصفحة الرئيسية">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2.8 14.7 8l5.8.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1L9.3 8 12 2.8Z" />
                        <path d="M9.5 12.2h5" />
                    </svg>
                </span>
                <span>
                    <span class="brand-name">نُــــور</span>
                    <span class="brand-caption">إدارة حساباتك ببساطة</span>
                </span>
            </a>

            <nav class="main-nav" aria-label="التنقل الرئيسي">
                <a href="#features">المميزات</a>
                <a href="#screens">داخل التطبيق</a>
                <a href="#how-it-works">كيف تبدأ؟</a>
                <a href="#download">التحميل</a>
            </nav>

            <div class="header-actions">
                <a href="{{ url('/admin/notifications') }}" class="admin-link" title="إدارة الإشعارات"
                    aria-label="إدارة الإشعارات">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4" />
                    </svg>
                </a>
                <a href="{{ url('/admin/features') }}" class="admin-link" title="التحكم بالميزات"
                    aria-label="التحكم بالميزات">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7h9M17 7h3M4 17h3m4 0h9M13 4v6M7 14v6" />
                        <circle cx="15" cy="7" r="2" />
                        <circle cx="9" cy="17" r="2" />
                    </svg>
                </a>
                <a href="{{ $downloadUrl }}" download class="button button-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 17v3h16v-3" />
                    </svg>
                    تحميل التطبيق
                </a>
                <button type="button" class="menu-toggle" id="menuToggle" aria-label="فتح قائمة التنقل"
                    aria-expanded="false" aria-controls="mobileNav">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round">
                        <path d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
        </div>
        <nav class="container mobile-nav" id="mobileNav" aria-label="التنقل للأجهزة الصغيرة">
            <a href="#features">المميزات</a>
            <a href="#screens">داخل التطبيق</a>
            <a href="#how-it-works">كيف تبدأ؟</a>
            <a href="#download">التحميل</a>
            <a href="{{ url('/admin/notifications') }}">إدارة الإشعارات</a>
            <a href="{{ url('/admin/features') }}">التحكم بالميزات</a>
        </nav>
    </header>

    <main>
        <!-- Hero -->
        <section class="hero">
            <div class="container hero-grid">
                <div class="hero-copy reveal">
                    <div class="release-line">
                        <span class="release-dot"></span>
                        <span>الإصدار المتاح</span>
                        <strong>v{{ $version }}</strong>
                        <span aria-hidden="true">·</span>
                        <span>جاهز لأجهزة أندرويد</span>
                    </div>
                    <h1 class="hero-title">رتّب حساباتك،<br>وخلي <span class="accent">نُور</span> يتابع التفاصيل.</h1>
                    <p class="hero-description">
                        كل ما تحتاجه لإدارة زبائنك وفواتيرك ودفعاتك في مكان واحد. تابع الأرصدة والديون المتأخرة، واحتفظ
                        بكشف حساب واضح يساعدك على إدارة تجارتك بثقة.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ $downloadUrl }}" download class="button button-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 17v3h16v-3" />
                            </svg>
                            <span>حمّل تطبيق نُور</span>
                        </a>
                        <a href="#screens" class="button button-light">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="6" y="2.5" width="12" height="19" rx="2" />
                                <path d="M10 18h4" />
                            </svg>
                            <span>شاهد الواجهات</span>
                        </a>
                    </div>
                    <div class="hero-meta">
                        <span class="hero-meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m5 12 4 4L19 6" />
                            </svg> تنظيم الفواتير والدفعات</span>
                        <span class="hero-meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m5 12 4 4L19 6" />
                            </svg> متابعة الديون</span>
                        <span class="hero-meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m5 12 4 4L19 6" />
                            </svg> تقارير PDF</span>
                    </div>
                </div>

                <div class="hero-visual reveal" aria-label="معاينة لتطبيق نور">
                    <div class="visual-backdrop"></div>
                    <div class="visual-ring"></div>
                    <div class="hero-device">
                        <div class="device-screen">
                            <span class="device-camera"></span>
                            @if (file_exists(public_path('images/screenshots/invoices.jpg')))
                                <img src="{{ asset('images/screenshots/invoices.jpg') }}"
                                    alt="شاشة الفواتير في تطبيق نور">
                            @elseif(file_exists(public_path('images/screenshots/screen1.png')))
                                <img src="{{ asset('images/screenshots/screen1.png') }}" alt="واجهة تطبيق نور">
                            @else
                                <div class="preview-ui">
                                    <div class="preview-top">
                                        <small>أهلاً بك في نُور</small>
                                        <strong>مؤسسة النور التجارية</strong>
                                    </div>
                                    <div class="preview-heading">ملخص الحسابات <span>نظرة عامة</span></div>
                                    <div class="preview-balance">
                                        <small>إجمالي ديون السوق</small>
                                        <strong>38,500 <em>ل.س</em></strong>
                                        <div class="preview-balance-foot"><span>الفواتير: 55,000</span><span>المقبوضات:
                                                16,500</span></div>
                                    </div>
                                    <div class="preview-heading">حسابات تحتاج متابعة <span>عرض الكل</span></div>
                                    <div class="preview-list">
                                        <div class="preview-person">
                                            <div class="preview-person-info"><span
                                                    class="preview-avatar">و</span><span><strong>محل
                                                        الوفاء</strong><small>متأخر 45 يوماً</small></span></div>
                                            <b>7,200 ل.س</b>
                                        </div>
                                        <div class="preview-person">
                                            <div class="preview-person-info"><span
                                                    class="preview-avatar">ش</span><span><strong>مكتبة
                                                        الشرق</strong><small>متأخر 30 يوماً</small></span></div>
                                            <b>3,400 ل.س</b>
                                        </div>
                                        <div class="preview-person">
                                            <div class="preview-person-info"><span
                                                    class="preview-avatar">م</span><span><strong>متجر
                                                        المدينة</strong><small>دفعة مستحقة</small></span></div>
                                            <b>2,150 ل.س</b>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="float-note note-one">
                        <span class="float-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m5 12 4 4L19 6" />
                            </svg></span>
                        <span><small>تحديث الحساب</small><strong>كل دفعة في مكانها</strong></span>
                    </div>
                    <div class="float-note note-two">
                        <span class="float-icon" style="color:#98652e;background:#F7EBD7"><svg viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M12 9v4m0 4h.01M10.3 3.8 2.9 17.2A2 2 0 0 0 4.6 20h14.8a2 2 0 0 0 1.7-2.8L13.7 3.8a2 2 0 0 0-3.4 0Z" />
                            </svg></span>
                        <span><small>متابعة الديون</small><strong>لا تفوّت موعداً</strong></span>
                    </div>
                    <div class="hero-stamp"><span>وضوح أكبر<br>لتجارتك</span></div>
                </div>
            </div>
        </section>

        <!-- Key benefits -->
        <section class="highlights container" aria-label="أهم مزايا تطبيق نور">
            <div class="highlights-inner reveal">
                <div class="highlight">
                    <span class="highlight-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                            <path d="M14 3v5h5M9 13h6M9 17h6" />
                        </svg></span>
                    <span><strong>فواتير منظمة</strong><small>بسيطة أو مفصّلة</small></span>
                </div>
                <div class="highlight">
                    <span class="highlight-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 7h18M5 7v13h14V7M8 4h8M9 11h6M9 15h4" />
                        </svg></span>
                    <span><strong>حسابات واضحة</strong><small>رصيد كل زبون بسهولة</small></span>
                </div>
                <div class="highlight">
                    <span class="highlight-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 8v4l3 2" />
                            <circle cx="12" cy="12" r="9" />
                            <path d="M7 3 5 5" />
                        </svg></span>
                    <span><strong>متابعة الاستحقاق</strong><small>تصنيف الديون المتأخرة</small></span>
                </div>
                <div class="highlight">
                    <span class="highlight-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 3h10v18H7zM9 7h6M9 11h6M9 15h3" />
                        </svg></span>
                    <span><strong>تقارير قابلة للمشاركة</strong><small>تصدير كشوفات PDF</small></span>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="section features-section">
            <div class="container features-layout">
                <div class="features-aside reveal">
                    <span class="section-kicker">كل التفاصيل في مكان واحد</span>
                    <h2 class="section-heading">إدارة يومك التجاري، دون فوضى الحسابات.</h2>
                    <p class="section-copy">من تسجيل أول فاتورة إلى متابعة آخر دفعة، يجمع نُور العمليات اليومية ضمن
                        تجربة واضحة وسهلة الوصول.</p>
                    <div class="aside-note">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v18M3 12h18" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                        <p>واجهة واحدة تجمع بيانات الزبائن، حركات البيع والتحصيل، مع إمكانية الرجوع إلى التفاصيل عند
                            الحاجة.</p>
                    </div>
                </div>

                <div class="features-grid">
                    <article class="feature-card reveal">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M8 5h11v16H5V8l3-3Z" />
                                <path d="M8 5v3H5M9 12h6M9 16h6" />
                            </svg></div>
                        <h3>كشف حساب شامل</h3>
                        <p>اعرف إجمالي فواتير كل زبون ودفعاته ورصيده الحالي، مع البحث السريع وإمكانية تصدير الكشف بصيغة
                            PDF.</p>
                        <div class="feature-foot">تفاصيل واضحة لكل زبون</div>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon" style="color:#9B503B;background:#F8EAE4"><svg viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 8v4m0 4h.01" />
                                <path
                                    d="M10.3 3.8 2.9 17.2A2 2 0 0 0 4.6 20h14.8a2 2 0 0 0 1.7-2.8L13.7 3.8a2 2 0 0 0-3.4 0Z" />
                            </svg></div>
                        <h3>رادار الديون المتأخرة</h3>
                        <p>تابع الحسابات المتأخرة وصنّفها بحسب مدة التأخير 30 و60 و90 يوماً لتعرف ما يحتاج إلى متابعة
                            أولاً.</p>
                        <div class="feature-foot" style="color:#9B503B">متابعة زمنية للديون</div>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="5" y="3" width="14" height="18" rx="2" />
                                <path d="M8 7h8M8 11h2m4 0h2M8 15h2m4 0h2M8 18h8" />
                            </svg></div>
                        <h3>فواتير مرنة</h3>
                        <p>سجّل الفاتورة بسرعة أو أضف تفاصيل المواد والكميات وأسعار المفرد، واترك الحسابات تتحدّث
                            تلقائياً.</p>
                        <div class="feature-foot">إدخال سريع أو تفصيلي</div>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon" style="color:#3F7957;background:#E8F1E8"><svg viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect x="3" y="6" width="18" height="13" rx="2" />
                                <path d="M3 10h18M8 15h3" />
                            </svg></div>
                        <h3>سندات قبض ودفعات</h3>
                        <p>وثّق الدفعات النقدية والتسديد الجزئي، وشاهد أثر كل دفعة على رصيد الزبون مباشرة.</p>
                        <div class="feature-foot" style="color:#3F7957">تحديث الرصيد بعد التحصيل</div>
                    </article>
                    <article class="feature-card feature-wide reveal">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19V5M4 19h17" />
                                <path d="m7 15 4-4 3 2 5-7" />
                                <path d="M16 6h3v3" />
                            </svg></div>
                        <div>
                            <h3>صورة أوضح لحركة تجارتك</h3>
                            <p>راجع المبيعات والمقبوضات عبر فترات زمنية مختلفة، وتعرّف على الحسابات الأعلى مديونية من
                                خلال الرسوم البيانية والملخصات المالية.</p>
                            <div class="feature-foot">تقارير تساعدك على اتخاذ القرار</div>
                        </div>
                    </article>
                    <article class="feature-card reveal">
                        <div class="feature-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="5" y="10" width="14" height="11" rx="2" />
                                <path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3" />
                            </svg></div>
                        <h3>دخول آمن ومرن</h3>
                        <p>استخدم بصمة الإصبع أو الوجه لتسهيل الدخول، مع إمكانية استعراض الحسابات عند عدم توفر الإنترنت.
                        </p>
                        <div class="feature-foot">راحة في الاستخدام اليومي</div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Screens showcase -->
        <section id="screens" class="section screens-section">
            <div class="container">
                <div class="screens-head">
                    <div class="section-intro reveal">
                        <span class="section-kicker">تعرّف على تجربة نُور</span>
                        <h2 class="section-heading">شاهد التفاصيل<br>قبل أن تبدأ.</h2>
                        <p class="section-copy">تنقّل بين نماذج الشاشات لتتعرف على طريقة عرض الفواتير والحسابات
                            والتقارير داخل التطبيق.</p>
                    </div>
                    <a href="{{ $downloadUrl }}" download class="button button-light reveal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 17v3h16v-3" />
                        </svg>
                        جرّب التطبيق بنفسك
                    </a>
                </div>

                <div class="screen-workspace reveal">
                    <div class="screen-sidebar">
                        <div class="screen-sidebar-label">استعراض الشاشات</div>
                        <div class="screen-tabs-list" id="screenTabs">
                            <button type="button" onclick="switchScreen('screen-invoices')" id="tab-invoices"
                                class="screen-tab-btn active" aria-pressed="true">
                                <span class="tab-symbol"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M7 3h10v18l-5-3-5 3V3Z" />
                                        <path d="M9 8h6M9 12h6" />
                                    </svg></span> الفواتير اليومية
                            </button>
                            <button type="button" onclick="switchScreen('screen-customers')" id="tab-customers"
                                class="screen-tab-btn" aria-pressed="false">
                                <span class="tab-symbol"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="9" cy="8" r="3" />
                                        <path d="M3 20v-1a6 6 0 0 1 12 0v1M16 5a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v1" />
                                    </svg></span> كشف الزبائن
                            </button>
                            <button type="button" onclick="switchScreen('screen-overdue')" id="tab-overdue"
                                class="screen-tab-btn" aria-pressed="false">
                                <span class="tab-symbol"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 2" />
                                    </svg></span> الديون المتأخرة
                            </button>
                            <button type="button" onclick="switchScreen('screen-reports')" id="tab-reports"
                                class="screen-tab-btn" aria-pressed="false">
                                <span class="tab-symbol"><svg viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M4 19V5M4 19h17" />
                                        <path d="m7 15 4-4 3 2 5-7" />
                                    </svg></span> التقارير والرسوم
                            </button>
                        </div>
                        <p class="screen-description" id="screenDescription">سجّل مبيعاتك اليومية واحتفظ بتفاصيل
                            الفواتير ضمن سجل مرتب يسهل الرجوع إليه.</p>
                    </div>

                    <div class="screen-device-wrap">
                        <div class="showcase-device">
                            <div class="showcase-screen">
                                <div id="screen-invoices" class="screen-content">
                                    @if (file_exists(public_path('images/screenshots/invoices.jpg')))
                                        <img src="{{ asset('images/screenshots/invoices.jpg') }}"
                                            alt="شاشة الفواتير اليومية">
                                    @else
                                        <div class="screen-fallback"><span class="fallback-icon"><svg
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.7" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M7 3h10v18l-5-3-5 3V3Z" />
                                                    <path d="M9 8h6M9 12h6M9 16h3" />
                                                </svg></span>
                                            <h4>الفواتير اليومية</h4>
                                            <p>تسجيل مبيعات الزبائن وإصدار الفواتير، مع الوصول إلى تفاصيل كل عملية.</p>
                                        </div>
                                    @endif
                                </div>
                                <div id="screen-customers" class="screen-content" hidden>
                                    @if (file_exists(public_path('images/screenshots/screen1.png')))
                                        <img src="{{ asset('images/screenshots/screen1.png') }}"
                                            alt="شاشة كشف الزبائن">
                                    @else
                                        <div class="screen-fallback"><span class="fallback-icon"><svg
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.7" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="9" cy="8" r="3" />
                                                    <path
                                                        d="M3 20v-1a6 6 0 0 1 12 0v1M16 5a3 3 0 0 1 0 6M18 14a5 5 0 0 1 3 5v1" />
                                                </svg></span>
                                            <h4>كشف حساب الزبائن</h4>
                                            <p>عرض الأرصدة والمجاميع والبحث السريع وتصدير كشوفات الحساب.</p>
                                        </div>
                                    @endif
                                </div>
                                <div id="screen-overdue" class="screen-content" hidden>
                                    @if (file_exists(public_path('images/screenshots/screen2.png')))
                                        <img src="{{ asset('images/screenshots/screen2.png') }}"
                                            alt="شاشة الديون المتأخرة">
                                    @else
                                        <div class="screen-fallback"><span class="fallback-icon"><svg
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.7" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="9" />
                                                    <path d="M12 7v5l3 2" />
                                                </svg></span>
                                            <h4>الديون المتأخرة</h4>
                                            <p>فلترة الحسابات بحسب مدة التأخير ومتابعة المبالغ التي تحتاج إلى تحصيل.</p>
                                        </div>
                                    @endif
                                </div>
                                <div id="screen-reports" class="screen-content" hidden>
                                    @if (file_exists(public_path('images/screenshots/screen4.png')))
                                        <img src="{{ asset('images/screenshots/screen4.png') }}"
                                            alt="شاشة التقارير والرسوم البيانية">
                                    @else
                                        <div class="screen-fallback"><span class="fallback-icon"><svg
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.7" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path d="M4 19V5M4 19h17" />
                                                    <path d="m7 15 4-4 3 2 5-7" />
                                                </svg></span>
                                            <h4>التقارير والملخص المالي</h4>
                                            <p>مقارنة حركة المبيعات والمقبوضات واستعراض النتائج ضمن فترات مختلفة.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <span class="screen-device-label">تطبيق نُور · واجهات من الداخل</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Steps -->
        <section id="how-it-works" class="section steps-section">
            <div class="container">
                <div class="section-intro center reveal">
                    <span class="section-kicker">خطوات بسيطة للانطلاق</span>
                    <h2 class="section-heading">ابدأ خلال دقائق</h2>
                    <p class="section-copy">لا تحتاج إلى إعدادات معقدة. نزّل التطبيق، ثبّته، ثم ابدأ بتنظيم حساباتك
                        اليومية.</p>
                </div>
                <div class="steps-grid">
                    <article class="step-card reveal">
                        <span class="step-number">01</span>
                        <h3>حمّل تطبيق نُور</h3>
                        <p>اضغط على زر التحميل واحفظ ملف APK على هاتفك الأندرويد.</p>
                        <span class="step-connector"></span>
                    </article>
                    <article class="step-card reveal">
                        <span class="step-number">02</span>
                        <h3>ثبّت التطبيق وسجّل الدخول</h3>
                        <p>افتح الملف المحمّل وأكمل التثبيت، ثم سجّل الدخول إلى حسابك.</p>
                        <span class="step-connector"></span>
                    </article>
                    <article class="step-card reveal">
                        <span class="step-number">03</span>
                        <h3>ابدأ بتنظيم حساباتك</h3>
                        <p>أضف الزبائن وسجّل الفواتير والدفعات، وتابع الأرصدة والتقارير من مكان واحد.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Download -->
        <section id="download" class="download-section">
            <div class="container">
                <div class="download-panel reveal">
                    <div class="download-content">
                        <span class="download-badge"><span></span> النسخة المتاحة حالياً · v{{ $version }}</span>
                        <h2 class="download-title">خلّي حساباتك مرتّبة<br>من أول يوم.</h2>
                        <p class="download-copy">ابدأ باستخدام نُور لتنظيم الفواتير والدفعات ومتابعة حسابات الزبائن،
                            واجعل تفاصيل تجارتك أقرب إليك دائماً.</p>
                        <a href="{{ $downloadUrl }}" download class="button download-button">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 17v3h16v-3" />
                            </svg>
                            تحميل تطبيق نُور (APK)
                        </a>
                        <div class="download-notes">
                            <div class="download-note"><strong>01 — التنزيل</strong>اضغط زر التحميل لحفظ ملف التطبيق
                                على جهازك.</div>
                            <div class="download-note"><strong>02 — التثبيت</strong>افتح الملف المحمّل واتبع تعليمات
                                التثبيت على أندرويد.</div>
                            <div class="download-note"><strong>03 — الاستخدام</strong>سجّل الدخول وابدأ بإضافة الزبائن
                                والفواتير والدفعات.</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Mobile download action -->
    <div class="mobile-download">
        <a href="{{ $downloadUrl }}" download>
            <span class="mobile-download-copy">
                <span class="mobile-download-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 3v12m0 0 4-4m-4 4-4-4M4 17v3h16v-3" />
                    </svg></span>
                <span><strong>تحميل تطبيق نُور</strong><small>إصدار أندرويد v{{ $version }}</small></span>
            </span>
            <span class="mobile-download-tag">تنزيل APK</span>
        </a>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container footer-main">
            <a href="{{ url('/') }}" class="brand">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2.8 14.7 8l5.8.8-4.2 4.1 1 5.8-5.3-2.8-5.3 2.8 1-5.8-4.2-4.1L9.3 8 12 2.8Z" />
                    </svg></span>
                <span><span class="brand-name">تطبيق نُور</span><span class="brand-caption">إدارة حسابات الزبائن
                        والفواتير والديون</span></span>
            </a>
            <div class="footer-links">
                <a href="{{ url('/admin/notifications') }}">إدارة الإشعارات</a>
                <a href="{{ url('/admin/features') }}">التحكم بالميزات</a>
                <a href="#features">المميزات</a>
                <a href="#download">تحميل التطبيق</a>
            </div>
            <div class="footer-copy">جميع الحقوق محفوظة &copy; {{ date('Y') }} تطبيق نُور</div>
        </div>
    </footer>

    <script>
        // تبديل شاشات التطبيق مع تحديث حالة الأزرار والوصف
        const screenDescriptions = {
            'screen-invoices': 'سجّل مبيعاتك اليومية واحتفظ بتفاصيل الفواتير ضمن سجل مرتب يسهل الرجوع إليه.',
            'screen-customers': 'تابع إجمالي الفواتير والدفعات والرصيد الحالي لكل زبون من شاشة واحدة.',
            'screen-overdue': 'اعرف الحسابات المتأخرة بحسب مدة الاستحقاق وحدّد ما يحتاج إلى متابعة.',
            'screen-reports': 'راجع حركة المبيعات والمقبوضات والملخصات المالية خلال الفترات المختلفة.'
        };

        function switchScreen(screenId) {
            const screens = document.querySelectorAll('.screen-content');
            const tabs = document.querySelectorAll('.screen-tab-btn');
            const activeScreen = document.getElementById(screenId);

            if (!activeScreen) return;

            screens.forEach(function(screen) {
                screen.hidden = true;
            });
            activeScreen.hidden = false;

            tabs.forEach(function(tab) {
                const isActive = tab.id === screenId.replace('screen-', 'tab-');
                tab.classList.toggle('active', isActive);
                tab.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });

            const description = document.getElementById('screenDescription');
            if (description && screenDescriptions[screenId]) {
                description.textContent = screenDescriptions[screenId];
            }
        }

        // قائمة التنقل على الشاشات الصغيرة
        const menuToggle = document.getElementById('menuToggle');
        const mobileNav = document.getElementById('mobileNav');
        if (menuToggle && mobileNav) {
            menuToggle.addEventListener('click', function() {
                const isOpen = mobileNav.classList.toggle('open');
                menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                menuToggle.setAttribute('aria-label', isOpen ? 'إغلاق قائمة التنقل' : 'فتح قائمة التنقل');
            });

            mobileNav.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    mobileNav.classList.remove('open');
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.setAttribute('aria-label', 'فتح قائمة التنقل');
                });
            });
        }

        // ظهور العناصر تدريجياً عند الوصول إليها، مع دعم المتصفحات التي لا تدعم المراقب
        const revealItems = document.querySelectorAll('.reveal');
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12
            });

            revealItems.forEach(function(item) {
                revealObserver.observe(item);
            });
        } else {
            revealItems.forEach(function(item) {
                item.classList.add('is-visible');
            });
        }
    </script>
</body>

</html>
