@extends('layouts.app')

@section('title', 'About — DF_137')

@section('content')

{{-- ============ ABOUT HERO ============ --}}
<section class="about-hero">
    <div class="parallax-orb orb-purple" style="top:10%;left:-5%;" data-parallax-speed="0.3"></div>
    <div class="parallax-orb orb-red" style="bottom:5%;right:-5%;" data-parallax-speed="0.2"></div>

    <div class="about-profile-card reveal reveal-left">
        <div class="about-profile-card-inner" id="profileCard">
            <div class="about-profile-image">
                <img src="{{ $settings['profile_image'] ? asset('storage/' . $settings['profile_image']) : 'https://via.placeholder.com/500x500/2b0057/C7A6FF?text=DF_137' }}" alt="Daffa Aira Adrin">
            </div>
        </div>
    </div>

    <div class="about-text reveal reveal-right">
        <span class="section-label">About Me</span>
        <h2>Daffa Aira Adrin<br><span class="gradient-text">DF_137</span></h2>
        <p>{{ $settings['about_text'] ?? 'I am an Informatics student passionate about the intersection of creativity and technology. My journey spans 3D modeling, machine learning, and software development — each discipline informing and enriching the others.' }}</p>
        <p>From crafting immersive 3D visualizations to building intelligent systems that learn from data, I thrive at the boundary where art meets engineering. Every project is an opportunity to push boundaries and explore new possibilities.</p>
        <div style="margin-top:32px;display:flex;gap:16px;flex-wrap:wrap;">
            <a href="{{ route('contact') }}" class="btn btn-primary">Let's Collaborate</a>
            <a href="{{ route('portfolio.index') }}" class="btn btn-ghost">See My Work</a>
        </div>
    </div>
</section>

{{-- ============ STATS COUNTER ============ --}}
<section class="stats-section">
    <div class="stat-item reveal reveal-up">
        <div class="stat-number" data-counter="50">0</div>
        <div class="stat-label">Projects Completed</div>
    </div>
    <div class="stat-item reveal reveal-up stagger-1">
        <div class="stat-number" data-counter="3">0</div>
        <div class="stat-label">Disciplines</div>
    </div>
    <div class="stat-item reveal reveal-up stagger-2">
        <div class="stat-number" data-counter="15">0</div>
        <div class="stat-label">Technologies</div>
    </div>
    <div class="stat-item reveal reveal-up stagger-3">
        <div class="stat-number" data-counter="100">0</div>
        <div class="stat-label">Percent Passion</div>
    </div>
</section>

{{-- ============ TIMELINE ============ --}}
<section class="section" id="timeline-section">
    <div class="section-header reveal reveal-up">
        <span class="section-label">Journey</span>
        <h2 class="section-title">My Timeline</h2>
        <p class="section-subtitle">Key milestones in my academic and professional journey.</p>
    </div>

    <div class="timeline">
        <div class="timeline-item reveal reveal-up">
            <div class="timeline-content">
                <div class="timeline-date">2024 — Present</div>
                <h3 class="timeline-title">Informatics Student</h3>
                <p class="timeline-desc">Pursuing a degree in Informatics, focusing on machine learning, algorithms, and software engineering at Universitas Andalas.</p>
            </div>
            <div class="timeline-dot"></div>
            <div></div>
        </div>
        <div class="timeline-item reveal reveal-up">
            <div></div>
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-date">2023</div>
                <h3 class="timeline-title">3D Modeling Mastery</h3>
                <p class="timeline-desc">Advanced proficiency in Blender, creating complex models, textures, and animations for various creative projects.</p>
            </div>
        </div>
        <div class="timeline-item reveal reveal-up">
            <div class="timeline-content">
                <div class="timeline-date">2023</div>
                <h3 class="timeline-title">Machine Learning Projects</h3>
                <p class="timeline-desc">Developed ML models for classification, prediction, and computer vision tasks using TensorFlow and scikit-learn.</p>
            </div>
            <div class="timeline-dot"></div>
            <div></div>
        </div>
        <div class="timeline-item reveal reveal-up">
            <div></div>
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-date">2022</div>
                <h3 class="timeline-title">Programming Foundation</h3>
                <p class="timeline-desc">Built strong foundations in Python, C++, and web technologies. Started exploring the intersection of code and creativity.</p>
            </div>
        </div>
        <div class="timeline-item reveal reveal-up">
            <div class="timeline-content">
                <div class="timeline-date">2021</div>
                <h3 class="timeline-title">Creative Beginnings</h3>
                <p class="timeline-desc">Discovered passion for digital art and 3D creation. Began exploring Blender and the world of computer graphics.</p>
            </div>
            <div class="timeline-dot"></div>
            <div></div>
        </div>
    </div>
</section>

{{-- ============ CIRCULAR SKILLS ============ --}}
<section class="section" id="circular-skills">
    <div class="section-header reveal reveal-up">
        <span class="section-label">Proficiency</span>
        <h2 class="section-title">Technical Skills</h2>
        <p class="section-subtitle">A detailed breakdown of my technical capabilities.</p>
    </div>

    <div class="skills-circular-grid">
        <svg width="0" height="0" style="position:absolute;">
            <defs>
                <linearGradient id="circularGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#C7A6FF"/>
                    <stop offset="100%" stop-color="#5b001f"/>
                </linearGradient>
            </defs>
        </svg>

        <div class="circular-skill reveal reveal-scale">
            <div class="circular-progress" data-percent="95">
                <svg viewBox="0 0 150 150">
                    <circle class="bg-ring" cx="75" cy="75" r="65"/>
                    <circle class="fill-ring" cx="75" cy="75" r="65"/>
                </svg>
                <span class="circular-percent">0%</span>
            </div>
            <span class="circular-skill-name">Blender / 3D</span>
        </div>
        <div class="circular-skill reveal reveal-scale stagger-1">
            <div class="circular-progress" data-percent="88">
                <svg viewBox="0 0 150 150">
                    <circle class="bg-ring" cx="75" cy="75" r="65"/>
                    <circle class="fill-ring" cx="75" cy="75" r="65"/>
                </svg>
                <span class="circular-percent">0%</span>
            </div>
            <span class="circular-skill-name">Python / ML</span>
        </div>
        <div class="circular-skill reveal reveal-scale stagger-2">
            <div class="circular-progress" data-percent="85">
                <svg viewBox="0 0 150 150">
                    <circle class="bg-ring" cx="75" cy="75" r="65"/>
                    <circle class="fill-ring" cx="75" cy="75" r="65"/>
                </svg>
                <span class="circular-percent">0%</span>
            </div>
            <span class="circular-skill-name">Web Dev</span>
        </div>
        <div class="circular-skill reveal reveal-scale stagger-3">
            <div class="circular-progress" data-percent="82">
                <svg viewBox="0 0 150 150">
                    <circle class="bg-ring" cx="75" cy="75" r="65"/>
                    <circle class="fill-ring" cx="75" cy="75" r="65"/>
                </svg>
                <span class="circular-percent">0%</span>
            </div>
            <span class="circular-skill-name">TensorFlow</span>
        </div>
        <div class="circular-skill reveal reveal-scale stagger-4">
            <div class="circular-progress" data-percent="78">
                <svg viewBox="0 0 150 150">
                    <circle class="bg-ring" cx="75" cy="75" r="65"/>
                    <circle class="fill-ring" cx="75" cy="75" r="65"/>
                </svg>
                <span class="circular-percent">0%</span>
            </div>
            <span class="circular-skill-name">C++ / DSA</span>
        </div>
        <div class="circular-skill reveal reveal-scale stagger-5">
            <div class="circular-progress" data-percent="75">
                <svg viewBox="0 0 150 150">
                    <circle class="bg-ring" cx="75" cy="75" r="65"/>
                    <circle class="fill-ring" cx="75" cy="75" r="65"/>
                </svg>
                <span class="circular-percent">0%</span>
            </div>
            <span class="circular-skill-name">UI/UX Design</span>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
// 3D profile card tilt
document.addEventListener('DOMContentLoaded', () => {
    const card = document.getElementById('profileCard');
    if (card) {
        const wrapper = card.parentElement;
        wrapper.addEventListener('mousemove', (e) => {
            const rect = wrapper.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;
            card.style.transform = `rotateY(${x * 20}deg) rotateX(${-y * 20}deg)`;
        });
        wrapper.addEventListener('mouseleave', () => {
            card.style.transform = 'rotateY(0) rotateX(0)';
        });
    }
});
</script>
@endsection
