/* ============================================
   DF_137 — THREE-SCENE.JS
   Particle Field, Floating Geometry, POV Camera
   ============================================ */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        return;
    }

    if (typeof THREE === 'undefined') {
        console.warn('Three.js not loaded, skipping 3D scene.');
        return;
    }

    const canvas = document.getElementById('threeCanvas');
    if (!canvas) return;

    // ============================================
    // SCENE SETUP
    // ============================================
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x150B22, 0.025);

    const camera = new THREE.PerspectiveCamera(
        75,
        window.innerWidth / window.innerHeight,
        0.1,
        1000
    );
    camera.position.set(0, 0, 50);

    const renderer = new THREE.WebGLRenderer({
        canvas: canvas,
        antialias: true,
        alpha: true,
    });
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);

    // ============================================
    // PARTICLE SYSTEM — 2000+ PARTICLES
    // ============================================
    const particleCount = 2500;
    const particleGeometry = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const colors = new Float32Array(particleCount * 3);
    const sizes = new Float32Array(particleCount);

    // Color palette: purple #C7A6FF, deep purple #2b0057, red #5b001f, accent #4a0149
    const colorPalette = [
        new THREE.Color(0xC7A6FF),  // accent purple
        new THREE.Color(0x2b0057),  // deep purple
        new THREE.Color(0x5b001f),  // deep red
        new THREE.Color(0x4a0149),  // mid purple
        new THREE.Color(0xF5F3FF),  // text white (sparse)
    ];

    for (let i = 0; i < particleCount; i++) {
        const i3 = i * 3;

        // Distribute in a sphere
        const radius = Math.random() * 80 + 20;
        const theta = Math.random() * Math.PI * 2;
        const phi = Math.acos(2 * Math.random() - 1);

        positions[i3] = radius * Math.sin(phi) * Math.cos(theta);
        positions[i3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
        positions[i3 + 2] = radius * Math.cos(phi);

        // Pick color (mostly purple/red, occasional white)
        const colorIndex = Math.random() < 0.05 ? 4 : Math.floor(Math.random() * 4);
        const color = colorPalette[colorIndex];
        colors[i3] = color.r;
        colors[i3 + 1] = color.g;
        colors[i3 + 2] = color.b;

        // Random sizes
        sizes[i] = Math.random() * 2 + 0.5;
    }

    particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particleGeometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
    particleGeometry.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

    // Custom shader material for glowing particles
    const particleMaterial = new THREE.ShaderMaterial({
        uniforms: {
            time: { value: 0 },
            pixelRatio: { value: renderer.getPixelRatio() },
        },
        vertexShader: `
            attribute float size;
            attribute vec3 color;
            varying vec3 vColor;
            uniform float time;
            uniform float pixelRatio;

            void main() {
                vColor = color;
                vec3 pos = position;
                // Gentle floating motion
                pos.y += sin(time * 0.5 + position.x * 0.01) * 2.0;
                pos.x += cos(time * 0.3 + position.z * 0.01) * 1.5;

                vec4 mvPosition = modelViewMatrix * vec4(pos, 1.0);
                gl_PointSize = size * pixelRatio * (300.0 / -mvPosition.z);
                gl_Position = projectionMatrix * mvPosition;
            }
        `,
        fragmentShader: `
            varying vec3 vColor;

            void main() {
                float dist = length(gl_PointCoord - vec2(0.5));
                if (dist > 0.5) discard;
                float alpha = 1.0 - smoothstep(0.0, 0.5, dist);
                alpha = pow(alpha, 1.5);
                gl_FragColor = vec4(vColor, alpha * 0.8);
            }
        `,
        transparent: true,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
    });

    const particleSystem = new THREE.Points(particleGeometry, particleMaterial);
    scene.add(particleSystem);

    // ============================================
    // FLOATING GEOMETRIC SHAPES (WIREFRAME)
    // ============================================
    const shapes = [];

    // Icosahedrons
    for (let i = 0; i < 4; i++) {
        const geo = new THREE.IcosahedronGeometry(Math.random() * 3 + 2, 0);
        const mat = new THREE.MeshBasicMaterial({
            color: i % 2 === 0 ? 0xC7A6FF : 0x5b001f,
            wireframe: true,
            transparent: true,
            opacity: 0.3,
        });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.position.set(
            (Math.random() - 0.5) * 60,
            (Math.random() - 0.5) * 40,
            (Math.random() - 0.5) * 40 - 20
        );
        mesh.userData = {
            rotSpeed: { x: Math.random() * 0.005, y: Math.random() * 0.005, z: Math.random() * 0.003 },
            floatSpeed: Math.random() * 0.01 + 0.005,
            floatOffset: Math.random() * Math.PI * 2,
            originalY: mesh.position.y,
        };
        scene.add(mesh);
        shapes.push(mesh);
    }

    // Torus Knots
    for (let i = 0; i < 3; i++) {
        const geo = new THREE.TorusKnotGeometry(Math.random() * 2 + 1.5, 0.4, 64, 8, 2, 3);
        const mat = new THREE.MeshBasicMaterial({
            color: i % 2 === 0 ? 0x4a0149 : 0xC7A6FF,
            wireframe: true,
            transparent: true,
            opacity: 0.25,
        });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.position.set(
            (Math.random() - 0.5) * 60,
            (Math.random() - 0.5) * 40,
            (Math.random() - 0.5) * 40 - 10
        );
        mesh.userData = {
            rotSpeed: { x: Math.random() * 0.004, y: Math.random() * 0.004, z: Math.random() * 0.002 },
            floatSpeed: Math.random() * 0.008 + 0.003,
            floatOffset: Math.random() * Math.PI * 2,
            originalY: mesh.position.y,
        };
        scene.add(mesh);
        shapes.push(mesh);
    }

    // Octahedrons
    for (let i = 0; i < 3; i++) {
        const geo = new THREE.OctahedronGeometry(Math.random() * 2 + 1.5, 0);
        const mat = new THREE.MeshBasicMaterial({
            color: 0x2b0057,
            wireframe: true,
            transparent: true,
            opacity: 0.35,
        });
        const mesh = new THREE.Mesh(geo, mat);
        mesh.position.set(
            (Math.random() - 0.5) * 50,
            (Math.random() - 0.5) * 30,
            (Math.random() - 0.5) * 30 - 5
        );
        mesh.userData = {
            rotSpeed: { x: Math.random() * 0.006, y: Math.random() * 0.006, z: Math.random() * 0.003 },
            floatSpeed: Math.random() * 0.01 + 0.004,
            floatOffset: Math.random() * Math.PI * 2,
            originalY: mesh.position.y,
        };
        scene.add(mesh);
        shapes.push(mesh);
    }

    // ============================================
    // DYNAMIC LIGHTING (purple/red)
    // ============================================
    const ambientLight = new THREE.AmbientLight(0x2b0057, 0.5);
    scene.add(ambientLight);

    const purpleLight = new THREE.PointLight(0xC7A6FF, 2, 100);
    purpleLight.position.set(30, 20, 30);
    scene.add(purpleLight);

    const redLight = new THREE.PointLight(0x5b001f, 1.5, 100);
    redLight.position.set(-30, -20, 20);
    scene.add(redLight);

    const accentLight = new THREE.PointLight(0x4a0149, 1, 80);
    accentLight.position.set(0, 30, -20);
    scene.add(accentLight);

    // ============================================
    // POV CAMERA — MOUSE TRACKING
    // ============================================
    let mouseX = 0, mouseY = 0;
    let targetX = 0, targetY = 0;
    let scrollProgress = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = (e.clientX / window.innerWidth) * 2 - 1;
        mouseY = -(e.clientY / window.innerHeight) * 2 + 1;
    });

    // Scroll-driven camera movement
    window.addEventListener('scroll', () => {
        const scrollMax = document.documentElement.scrollHeight - window.innerHeight;
        scrollProgress = scrollMax > 0 ? window.scrollY / scrollMax : 0;
    }, { passive: true });

    // ============================================
    // ANIMATION LOOP
    // ============================================
    const clock = new THREE.Clock();
    let isVisible = true;
    let animationId = null;

    function animate() {
        animationId = requestAnimationFrame(animate);
        if (!isVisible) return;

        const elapsed = clock.getElapsedTime();

        // Update particle shader time
        particleMaterial.uniforms.time.value = elapsed;

        // Rotate particle system slowly
        particleSystem.rotation.y = elapsed * 0.02;
        particleSystem.rotation.x = elapsed * 0.01;

        // Animate floating shapes
        shapes.forEach((shape, i) => {
            shape.rotation.x += shape.userData.rotSpeed.x;
            shape.rotation.y += shape.userData.rotSpeed.y;
            shape.rotation.z += shape.userData.rotSpeed.z;
            shape.position.y = shape.userData.originalY + Math.sin(elapsed * shape.userData.floatSpeed + shape.userData.floatOffset) * 3;
        });

        // POV camera: smooth follow mouse + scroll
        targetX += (mouseX * 10 - targetX) * 0.05;
        targetY += (mouseY * 8 - targetY) * 0.05;

        camera.position.x = targetX;
        camera.position.y = targetY;
        camera.position.z = 50 - scrollProgress * 20; // Move camera forward on scroll
        camera.lookAt(0, 0, 0);

        // Animate lights
        purpleLight.position.x = Math.sin(elapsed * 0.3) * 40;
        purpleLight.position.z = Math.cos(elapsed * 0.3) * 40;
        redLight.position.x = Math.sin(elapsed * 0.2 + Math.PI) * 35;
        redLight.position.y = Math.cos(elapsed * 0.2 + Math.PI) * 30;

        renderer.render(scene, camera);
    }

    animate();

    // ============================================
    // RESIZE HANDLER
    // ============================================
    let resizeTimeout = null;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            particleMaterial.uniforms.pixelRatio.value = renderer.getPixelRatio();
        }, 100);
    });

    // ============================================
    // PERFORMANCE: PAUSE WHEN NOT VISIBLE
    // ============================================
    document.addEventListener('visibilitychange', () => {
        isVisible = !document.hidden;
        if (isVisible && !animationId) {
            animate();
        } else if (!isVisible && animationId) {
            cancelAnimationFrame(animationId);
            animationId = null;
        }
    });

    // Also pause when canvas is off-screen (scrolled far down)
    if ('IntersectionObserver' in window) {
        const canvasObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // The canvas is fixed, so it's always "visible" in viewport terms.
                // Instead, check if we've scrolled past the first viewport
                if (window.scrollY > window.innerHeight * 2) {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                        animationId = null;
                    }
                } else {
                    if (!animationId) {
                        animate();
                    }
                }
            });
        }, { threshold: 0 });
        canvasObserver.observe(canvas);
    }

})();
