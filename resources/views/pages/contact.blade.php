@extends('layouts.app')

@section('title', 'Contact — DF_137')

@section('content')

<section class="contact-section">
    <div class="parallax-orb orb-purple" style="top:5%;left:-10%;" data-parallax-speed="0.3"></div>
    <div class="parallax-orb orb-red" style="bottom:10%;right:-10%;" data-parallax-speed="0.2"></div>

    {{-- Info Side --}}
    <div class="contact-info reveal reveal-left">
        <span class="section-label">Get in Touch</span>
        <h2>Let's Create<br><span class="gradient-text">Something Amazing</span></h2>
        <p>Have a project in mind, a collaboration idea, or just want to say hello? I'm always open to discussing new opportunities and creative ventures. Drop me a message and I'll get back to you soon.</p>

        <div style="margin-bottom:32px;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                <div class="contact-social-link" style="width:40px;height:40px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                </div>
                <a href="mailto:2411531006_daffa@unand.ac.id" style="color:var(--text-muted);font-size:0.9rem;">2411531006_daffa@unand.ac.id</a>
            </div>
        </div>

        <div class="contact-social">
            <a href="https://github.com/DaffaAiraAdrn" target="_blank" rel="noopener" class="contact-social-link" aria-label="GitHub">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 .5C5.37.5 0 5.78 0 12.29c0 5.21 3.44 9.63 8.21 11.19.6.11.82-.25.82-.56v-2.02c-3.34.71-4.04-1.59-4.04-1.59-.55-1.37-1.34-1.74-1.34-1.74-1.09-.73.08-.72.08-.72 1.21.08 1.85 1.22 1.85 1.22 1.07 1.8 2.81 1.28 3.5.98.11-.76.42-1.28.76-1.57-2.67-.3-5.47-1.3-5.47-5.79 0-1.28.47-2.33 1.23-3.15-.12-.3-.53-1.51.12-3.15 0 0 1-.32 3.3 1.2a11.6 11.6 0 0 1 6 0c2.3-1.52 3.3-1.2 3.3-1.2.65 1.64.24 2.85.12 3.15.77.82 1.23 1.87 1.23 3.15 0 4.5-2.81 5.48-5.49 5.78.43.36.81 1.08.81 2.18v3.23c0 .31.22.68.83.56A12.01 12.01 0 0 0 24 12.29C24 5.78 18.63.5 12 .5z"/></svg>
            </a>
            <a href="https://youtube.com/@360hz4" target="_blank" rel="noopener" class="contact-social-link" aria-label="YouTube">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M23.5 6.2a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.51A3.02 3.02 0 0 0 .5 6.2C0 8.08 0 12 0 12s0 3.92.5 5.8a3.02 3.02 0 0 0 2.12 2.14c1.88.51 9.38.51 9.38.51s7.5 0 9.38-.51a3.02 3.02 0 0 0 2.12-2.14C24 15.92 24 12 24 12s0-3.92-.5-5.8zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/></svg>
            </a>
            <a href="https://instagram.com/df__137" target="_blank" rel="noopener" class="contact-social-link" aria-label="Instagram">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.13 1.38A5.9 5.9 0 0 0 .63 4.14c-.3.76-.5 1.64-.56 2.91C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.38 2.13.67.66 1.34 1.07 2.13 1.38.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.9 5.9 0 0 0 2.13-1.38 5.9 5.9 0 0 0 1.38-2.13c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.9 5.9 0 0 0-1.38-2.13A5.9 5.9 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.41-10.85a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/></svg>
            </a>
            <a href="mailto:2411531006_daffa@unand.ac.id" class="contact-social-link" aria-label="Email">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M24 5.46c0-.34-.01-.67-.04-1H0c-.03.33-.04.66-.04 1v13.08c0 1.98 1.6 3.58 3.58 3.58h16.84c1.98 0 3.58-1.6 3.58-3.58V5.46zM3.58 2.04h16.84C22.4 2.04 24 3.64 24 5.62v.06L12 13.5 0 5.68v-.06c0-1.98 1.6-3.58 3.58-3.58z"/></svg>
            </a>
        </div>
    </div>

    {{-- Form Side --}}
    <div class="contact-form-wrapper reveal reveal-right" id="contactFormWrapper">
        <form class="contact-form" id="contactForm" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div class="form-message success" id="formSuccess">Your message has been sent successfully. I'll get back to you soon!</div>
            <div class="form-message error" id="formError">Something went wrong. Please try again or email me directly.</div>

            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" class="form-input" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" class="form-input" placeholder="Project Inquiry" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" class="form-textarea" placeholder="Tell me about your project..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;" id="submitBtn">
                <span id="submitText">Send Message</span>
            </button>
        </form>
    </div>
</section>

@endsection
