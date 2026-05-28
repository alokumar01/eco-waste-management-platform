<div class="space-y-6">
    <!-- Table of Contents -->
    <div id="toc-container" class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hidden">
        <h3 class="font-bold text-gray-900 mb-4 text-lg">Table of Contents</h3>
        <ul id="toc-list" class="text-sm font-medium p-0 m-0 list-none">
            <!-- Dynamic TOC items injected via JS -->
        </ul>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const article = document.querySelector('article.prose');
        if (!article) return;

        const headings = article.querySelectorAll('h1, h2');
        const tocContainer = document.getElementById('toc-container');
        const tocList = document.getElementById('toc-list');

        if (!tocContainer || !tocList) return;

        if (headings.length === 0) {
            tocContainer.classList.add('hidden');
            return;
        }

        tocContainer.classList.remove('hidden');

        headings.forEach((heading, index) => {
            if (!heading.id) {
                heading.id = 'heading-' + index + '-' + heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-');
            }

            const li = document.createElement('li');
            const isH2 = heading.tagName.toLowerCase() === 'h2';
            
            li.innerHTML = `
                <a href="#${heading.id}" class="toc-link flex items-center gap-3 py-2 px-0 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-green-800 transition-all ${isH2 ? 'pl-5 text-xs font-semibold' : ''}">
                    <div class="rounded-full ${isH2 ? 'w-1 h-1 bg-gray-300' : 'w-1.5 h-1.5 bg-gray-400'} shrink-0 dot-marker transition-colors"></div>
                    <span class="truncate">${heading.textContent.trim()}</span>
                </a>
            `;
            tocList.appendChild(li);
        });

        const tocLinks = document.querySelectorAll('.toc-link');

        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const navBar = document.querySelector('nav') || document.querySelector('header');
                    const navHeight = navBar ? navBar.offsetHeight : 80;
                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navHeight - 24; // 24px extra padding

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    
                    history.pushState(null, null, '#' + targetId);
                }
            });
        });
        
        function highlightToc() {
            let currentActive = null;
            const scrollPosition = window.scrollY + 120;

            headings.forEach(heading => {
                if (scrollPosition >= heading.offsetTop) {
                    currentActive = heading.id;
                }
            });

            tocLinks.forEach(link => {
                const href = link.getAttribute('href');
                const dot = link.querySelector('.dot-marker');
                if (href === `#${currentActive}`) {
                    link.classList.remove('text-gray-500');
                    link.classList.add('bg-green-50', 'text-green-800');
                    if (dot) {
                        dot.classList.remove('bg-gray-300', 'bg-gray-400');
                        dot.classList.add('bg-green-600');
                    }
                } else {
                    link.classList.remove('bg-green-50', 'text-green-800');
                    link.classList.add('text-gray-500');
                    if (dot) {
                        dot.classList.remove('bg-green-600');
                        const isH2Link = link.classList.contains('pl-5');
                        dot.classList.add(isH2Link ? 'bg-gray-300' : 'bg-gray-400');
                    }
                }
            });
        }

        window.addEventListener('scroll', highlightToc);
        highlightToc();

        // Handle initial load with hash
        if (window.location.hash) {
            setTimeout(() => {
                const targetId = window.location.hash.substring(1);
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    const navBar = document.querySelector('nav') || document.querySelector('header');
                    const navHeight = navBar ? navBar.offsetHeight : 80;
                    const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - navHeight - 24;
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }, 100);
        }
    });
    </script>

    <!-- Related Articles -->
    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center gap-2 mb-4">
            <i class="fa-solid fa-leaf text-green-theme text-xs"></i>
            <h3 class="font-bold text-gray-900 text-lg">Related Articles</h3>
        </div>
        <div class="space-y-4">
            @foreach ($popularPosts as $article)
                <a href="{{ route('public.blog.show', $article->slug) }}" class="flex gap-4 group items-start">
                    <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : 'https://images.unsplash.com/photo-1592476579628-9d41b0b5fe8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0 bg-gray-100">
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-bold text-gray-900 group-hover:text-green-700 transition-colors line-clamp-2 leading-snug">{{ $article->title }}</div>
                        <div class="text-[11px] text-gray-500 mt-1">{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Stay Updated -->
    <div class="bg-green-tint border border-green-50 rounded-2xl p-6 relative overflow-hidden flex flex-col justify-center h-[280px]">
        <h3 class="font-bold text-gray-900 mb-2 relative z-10 text-xl">Stay Updated</h3>
        <p class="text-gray-600 text-sm mb-6 relative z-10 w-2/3">Subscribe to get the latest articles and sustainability tips.</p>
        <div class="relative z-10 w-5/6">
            <div class="relative mb-3">
                <i class="fa-regular fa-envelope absolute left-3 top-3 text-gray-400 text-sm"></i>
                <input type="email" placeholder="Enter your email" class="w-full bg-white border border-gray-200 text-sm rounded-lg pl-9 pr-4 py-2.5 focus:outline-none focus:border-green-theme shadow-sm">
            </div>
            <button class="w-full bg-[#357635] text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-green-800 transition-colors shadow-sm">Subscribe</button>
        </div>
        <div class="absolute -bottom-10 -right-6 z-0 opacity-80 pointer-events-none">
            <svg width="150" height="150" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M120 180C120 180 90 140 100 90C110 40 160 20 160 20C160 20 180 60 160 110C140 160 120 180 120 180Z" fill="#A3E635" opacity="0.3"/>
                <path d="M110 190C110 190 70 160 60 110C50 60 80 30 80 30C80 30 110 50 120 100C130 150 110 190 110 190Z" fill="#84CC16" opacity="0.4"/>
                <path d="M140 160C140 160 130 110 150 70C170 30 210 20 210 20C210 20 220 70 190 110C160 150 140 160 140 160Z" fill="#4D7C0F" opacity="0.2"/>
            </svg>
        </div>
    </div>
</div>
