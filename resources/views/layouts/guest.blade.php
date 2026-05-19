<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GreenLoop') }} - Authentication</title>

    <!-- Google Fonts Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Outfit', sans-serif;
        }

        /* ========================================================
           HIGH-SPECIFICITY OVERRIDES FOR THE ECO AUTHENTICATION CARD
           ======================================================== */
        
        /* 1. Body Screen Backdrop override */
        body.guest-page {
            background-color: #F5F6F0 !important;
            color: #1A3020 !important;
        }

        /* 2. Left Brand Showcase heading, subtitle, and paragraph forced white/light gray */
        body.guest-page .brand-showcase h2.showcase-heading {
            color: #ffffff !important;
            font-size: 34px !important;
            line-height: 1.1 !important;
            font-weight: 800 !important;
            font-family: 'Outfit', sans-serif !important;
            letter-spacing: -0.025em !important;
        }
        body.guest-page .brand-showcase h2.showcase-heading span {
            color: #84E296 !important;
        }
        body.guest-page .brand-showcase p.showcase-description {
            color: #CBD5E1 !important;
            font-size: 11.5px !important;
            font-weight: 500 !important;
            line-height: 1.625 !important;
        }
        body.guest-page .brand-showcase p.showcase-meta {
            color: #E2E4DE !important;
            font-size: 9px !important;
            font-weight: 700 !important;
            letter-spacing: 0.05em !important;
        }
        body.guest-page .brand-showcase svg.showcase-footer-icon {
            color: #84E296 !important;
        }

        /* 3. Input background, padding, height, and placeholder styling */
        body.guest-page .guest-input-container input.guest-input,
        body.guest-page .guest-input-container select.guest-input {
            background-color: #E2E4DE !important; /* Sage gray color from mockup */
            border: 1px solid transparent !important;
            border-radius: 0.75rem !important; /* rounded-xl */
            padding-left: 2.75rem !important; /* 44px left padding so text never overlaps left icons */
            padding-right: 1rem !important;
            height: 3rem !important; /* h-12 height */
            font-size: 0.75rem !important;
            color: #1A3020 !important;
            font-weight: 500 !important;
            box-shadow: none !important;
            transition: all 0.2s ease-in-out !important;
        }

        body.guest-page .guest-input-container input.guest-input::placeholder {
            color: #7A8E7D !important; /* High contrast sage placeholder */
            opacity: 1 !important;
        }

        /* Focus state overrides */
        body.guest-page .guest-input-container input.guest-input:focus,
        body.guest-page .guest-input-container select.guest-input:focus {
            background-color: #ffffff !important;
            border-color: #609953 !important;
            outline: none !important;
            box-shadow: 0 0 0 2px rgba(96, 153, 83, 0.2) !important;
        }

        /* 4. Action Button Styling */
        body.guest-page button.btn-primary-mockup {
            background-color: #609953 !important; /* Mockup brand green */
            color: #ffffff !important;
            font-weight: 700 !important;
            border-radius: 0.75rem !important; /* rounded-xl */
            height: 3rem !important; /* h-12 height */
            font-size: 0.75rem !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(96, 153, 83, 0.15) !important;
            transition: all 0.2s ease-in-out !important;
        }
        body.guest-page button.btn-primary-mockup:hover {
            background-color: #4F7F44 !important;
            box-shadow: 0 6px 16px rgba(96, 153, 83, 0.25) !important;
        }

        /* 5. Custom link styles for guest panel */
        body.guest-page a.guest-link-green {
            color: #609953 !important;
            font-weight: 700 !important;
            transition: color 0.2s !important;
        }
        body.guest-page a.guest-link-green:hover {
            color: #4F7F44 !important;
            text-decoration: underline !important;
        }
    </style>
</head>

<body class="guest-page antialiased min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-10 bg-[#F5F6F0]">
    <!-- Outer Card Frame -->
    <div class="w-full max-w-[1100px] min-h-[660px] bg-white rounded-3xl shadow-[0_12px_45px_rgba(45,106,79,0.05)] border border-gray-100/80 overflow-hidden flex flex-col md:flex-row">
        
        <!-- Left Column: Premium Brand Showcase (Succulent Background & Centered Logo) -->
        <div class="hidden md:flex md:w-[45%] text-white p-10 flex-col justify-between relative overflow-hidden shrink-0 brand-showcase" style="background-image: url('{{ asset('auth-bg.jpg') }}'); background-size: cover; background-position: center;">
            <!-- Dark multiplier layer to perfectly replicate the inspiration image context -->
            <div class="absolute inset-0 bg-[#0E1C13]/85 mix-blend-multiply z-0"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#0E1C13]/90 via-[#0E1C13]/70 to-[#0E1C13]/95 z-0"></div>
            
            <!-- Top Subtitle -->
            <div class="z-10 select-none flex items-center gap-2">
                <span class="w-4 h-px bg-[#8BC34A]/80"></span>
                <p class="text-[9px] tracking-[0.25em] font-extrabold text-[#D1D8D4] uppercase font-heading">A GREENER FUTURE, TOGETHER</p>
            </div>

            <!-- Central Content: Big Green Circular succulent Logo -->
            <div class="z-10 my-auto flex flex-col items-center justify-center py-6 select-none">
                <!-- Exact crop of the GreenLoop round succulent logo -->
                <svg viewBox="1439 181.3 629 285" class="w-[190px] h-[100px]" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#689F38" d="M2055.69 268.503C2043.69 242.872 2023.75 221.121 1998.62 205.726C1986.11 198.074 1972.27 191.988 1957.42 187.838C1942.66 183.597 1926.9 181.383 1910.62 181.383C1889.76 181.383 1869.72 185.075 1851.41 191.809C1849.88 192.356 1848.46 192.906 1847.04 193.554C1830.56 200.099 1815.5 209.318 1802.59 220.292C1798.41 223.885 1794.45 227.665 1790.47 231.906C1783.46 239.189 1776.24 247.58 1769.22 256.06C1767.79 257.805 1766.26 259.651 1764.84 261.408C1760.98 266.197 1724.04 315.244 1717.54 324.003C1714.28 328.423 1710.41 333.401 1706.24 338.84C1705.32 340.038 1704.31 341.334 1703.3 342.621C1696.38 351.561 1688.65 360.969 1681.52 369.269C1677.97 373.411 1674.4 377.281 1671.35 380.513C1668.2 383.826 1665.35 386.501 1663.31 388.255C1654.57 395.719 1644.29 401.805 1633 405.955C1621.71 410.105 1609.4 412.41 1596.37 412.41C1587.42 412.41 1578.78 411.301 1570.64 409.276C1566.47 408.26 1562.4 406.972 1558.43 405.405C1540.93 398.761 1525.98 387.517 1515.5 373.409C1510.21 366.316 1506.04 358.573 1503.19 350.272C1500.44 341.971 1498.82 333.221 1498.82 324.002C1498.82 311.74 1501.57 300.217 1506.45 289.611C1513.88 273.757 1526.28 260.299 1541.85 250.71C1549.68 245.912 1558.22 242.229 1567.38 239.645C1576.53 237.061 1586.2 235.595 1596.37 235.595C1609.4 235.684 1621.71 237.9 1633 242.041C1644.29 246.28 1654.57 252.277 1663.31 259.74C1665.35 261.496 1668.2 264.259 1671.35 267.491C1676.84 273.298 1683.35 280.761 1689.87 288.603C1692.41 291.736 1694.95 294.869 1697.5 298.091C1707.26 285.191 1724.35 262.512 1733.3 250.799C1731.78 248.953 1730.25 247.118 1728.73 245.272C1724.66 240.563 1720.58 236.053 1716.52 231.902C1712.45 227.662 1708.58 223.881 1704.41 220.289C1690.37 208.296 1673.79 198.53 1655.58 191.804C1637.27 185.07 1617.23 181.378 1596.37 181.378C1574.71 181.378 1553.95 185.348 1535.04 192.631C1506.75 203.417 1482.84 221.485 1465.85 244.253C1457.41 255.598 1450.7 268.219 1446.02 281.588C1441.44 295.051 1439 309.249 1439 324.004C1439 343.639 1443.37 362.446 1451.31 379.497C1463.31 405.218 1483.25 426.888 1508.27 442.283C1520.89 449.935 1534.73 456.012 1549.58 460.252C1564.33 464.402 1580.1 466.617 1596.37 466.617C1617.23 466.617 1637.28 462.925 1655.58 456.201C1673.8 449.467 1690.28 439.698 1704.31 427.805L1704.41 427.715C1708.59 424.213 1712.45 420.333 1716.52 416.093C1723.54 408.81 1730.76 400.428 1737.78 391.947C1739.2 390.191 1740.73 388.435 1742.15 386.689C1746.02 381.8 1796.59 314.595 1800.75 309.158C1801.67 307.96 1802.69 306.673 1803.7 305.377C1810.62 296.526 1818.35 287.03 1825.48 278.738C1829.03 274.588 1832.6 270.716 1835.65 267.493C1838.8 264.171 1841.65 261.497 1843.69 259.742C1852.43 252.279 1862.71 246.283 1874 242.043C1876.75 241.035 1879.49 240.208 1882.34 239.369C1891.29 236.976 1900.75 235.688 1910.62 235.597C1924.15 235.687 1936.97 238.082 1948.56 242.601C1966.06 249.236 1981.02 260.48 1991.49 274.588C1996.79 281.691 2000.96 289.434 2003.8 297.724C2006.65 306.025 2008.18 314.784 2008.18 324.003C2008.18 336.265 2005.43 347.879 2000.55 358.385C1993.12 374.238 1980.71 387.796 1965.15 397.285C1957.32 402.083 1948.77 405.865 1939.61 408.35C1930.56 410.934 1920.8 412.411 1910.62 412.411C1897.6 412.411 1885.29 410.107 1874 405.956C1862.71 401.806 1852.43 395.72 1843.68 388.256C1841.65 386.501 1838.8 383.737 1835.65 380.514C1830.15 374.798 1823.64 367.235 1817.13 359.403C1814.49 356.269 1811.94 353.037 1809.4 349.815C1808.59 350.921 1807.77 352.03 1806.86 353.227C1790.07 375.536 1779.49 389.642 1773.69 397.286C1775.21 399.132 1776.74 400.887 1778.26 402.733C1782.34 407.432 1786.41 411.952 1790.47 416.093C1794.45 420.332 1798.41 424.213 1802.58 427.715C1816.62 439.698 1833.2 449.467 1851.41 456.201C1869.72 462.925 1889.76 466.617 1910.62 466.617C1932.29 466.617 1953.04 462.656 1971.86 455.463C2000.24 444.587 2024.15 426.519 2041.14 403.742C2049.58 392.408 2056.4 379.866 2060.97 366.407C2065.56 353.038 2068 338.751 2068 324.004C2068 304.369 2063.63 285.563 2055.69 268.503Z" />
                </svg>
            </div>

            <!-- Bottom Left Content Section -->
            <div class="z-10 select-none">
                <h2 class="font-heading font-extrabold showcase-heading">
                    Turn Waste <br>
                    <span>into Value</span>
                </h2>
                <p class="showcase-description mt-4">
                    Join a community that cares for the planet. Let's create a cleaner, greener tomorrow.
                </p>
                
                <!-- Bottom Divider Line -->
                <div class="h-px bg-white/10 w-full mt-6 mb-6"></div>

                <!-- Three Bottom Divided Columns -->
                <div class="grid grid-cols-3 text-center divide-x divide-white/15">
                    <div class="flex flex-col items-center gap-1.5">
                        <!-- Leaf Icon -->
                        <svg class="w-4 h-4 showcase-footer-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18M12 3c4 0 7 3 7 7v4c0 3-3 5-7 5s-7-2-7-5v-4c0-4 3-7 7-7z" />
                        </svg>
                        <p class="showcase-meta mt-1">Reduce Waste</p>
                    </div>
                    <div class="flex flex-col items-center gap-1.5 pl-2">
                        <!-- Recycle Icon -->
                        <svg class="w-4 h-4 showcase-footer-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H17" />
                        </svg>
                        <p class="showcase-meta mt-1">Compost Smart</p>
                    </div>
                    <div class="flex flex-col items-center gap-1.5 pl-2">
                        <!-- Community Icon -->
                        <svg class="w-4 h-4 showcase-footer-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="showcase-meta mt-1">Connect Locally</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Authentication Forms -->
        <div class="flex-1 p-6 sm:p-10 lg:p-14 flex flex-col justify-center bg-white">
            <!-- Center Aligned Brand Landscape Logo (Always Visible at the Top) -->
            <div class="flex items-center justify-center mb-8 select-none">
                <img src="{{ asset('icon-landscap.svg') }}" alt="GreenLoop Logo" class="w-[190px] h-auto object-contain">
            </div>

            <div class="w-full max-w-[420px] mx-auto">
                @yield('content')
            </div>
        </div>

    </div>
</body>

</html>