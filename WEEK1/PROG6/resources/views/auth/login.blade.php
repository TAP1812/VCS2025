<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --text: #2b2d42;
            --light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            background-attachment: fixed;
            color: var(--text);
            overflow-x: hidden;
        }
        
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }
        
        .login-container {
            position: relative;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
            text-align: center;
            z-index: 1;
            overflow: hidden;
            transition: var(--transition);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(67, 97, 238, 0.1), transparent);
            transform: rotate(45deg);
            z-index: -1;
            animation: shine 6s infinite;
        }
        
        @keyframes shine {
            0% { transform: rotate(45deg) translateX(-100%); }
            100% { transform: rotate(45deg) translateX(100%); }
        }
        
        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .logo {
            margin-bottom: 20px;
            font-size: 2.5rem;
            color: var(--primary);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
        }
        
        .login-container h2 {
            margin-bottom: 30px;
            font-weight: 700;
            color: var(--text);
            font-size: 1.8rem;
            position: relative;
            display: inline-block;
        }
        
        .login-container h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--accent);
            border-radius: 3px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }
        
        .form-group label {
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
            color: var(--text);
            transition: var(--transition);
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.1rem;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 15px;
            background-color: rgba(255, 255, 255, 0.8);
            color: var(--text);
        }
        
        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            background-color: var(--white);
        }
        
        .error {
            color: #ff4757;
            margin-bottom: 15px;
            font-size: 0.9rem;
            background: rgba(255, 71, 87, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            border-left: 4px solid #ff4757;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.3);
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: var(--transition);
        }
        
        .btn:hover::after {
            left: 100%;
        }
        
        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        
        .links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }
        
        .links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: var(--transition);
        }
        
        .links a:hover::after {
            width: 100%;
        }
        
        .social-login {
            margin-top: 30px;
        }
        
        .social-login p {
            position: relative;
            margin-bottom: 20px;
            color: #6c757d;
        }
        
        .social-login p::before,
        .social-login p::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: #dee2e6;
        }
        
        .social-login p::before {
            left: 0;
        }
        
        .social-login p::after {
            right: 0;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            transition: var(--transition);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .facebook { background: #3b5998; }
        .google { background: #db4437; }
        .twitter { background: #1da1f2; }
        
        .footer {
            margin-top: 30px;
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 0 15px;
            }
        }
    </style>
</head>
<body>
    <div class="particles" id="particles-js"></div>
    
    <div class="login-container">
        <div class="logo">
            <i class="fas fa-rocket"></i>
            <span>TapTap</span>
        </div>
        
        <h2>Đăng nhập</h2>
        
        @if ($errors->any())
            <div class="error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required placeholder="Nhập tên đăng nhập">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </div>
            
            <div class="links">
                <a href="{{ route('register') }}">Tạo tài khoản mới</a>
            </div>
        </form>
        
        <div class="footer">
            &copy; 2025 TapTap. All rights reserved.
        </div>
    </div>

    <!-- Particles.js for background animation -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Initialize particles.js
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    </script>
</body>
</html>