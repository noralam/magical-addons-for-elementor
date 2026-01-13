# Magical Addons for Elementor

![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/magical-addons-for-elementor)
![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/stars/magical-addons-for-elementor)
![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/magical-addons-for-elementor)
![WordPress Plugin Required PHP Version](https://img.shields.io/wordpress/plugin/required-php/magical-addons-for-elementor)
![License](https://img.shields.io/badge/license-GPL--2.0%2B-blue.svg)

**The ultimate free addon for Elementor with 60+ widgets, 100+ sections, Header/Footer Builder, GSAP Animations, and more!**

[Demo](https://magic.wpcolors.net/) | [Documentation](https://developer.developer/#) | [Support](https://wordpress.org/support/plugin/magical-addons-for-elementor/) | [Pro Version](https://magic.wpcolors.net/pricing-plan/)

---

## ✨ Features

### 🎨 60+ Free Widgets
Build stunning websites with our comprehensive collection of Elementor widgets:

| Widget | Description |
|--------|-------------|
| **Banner** | Create eye-catching banners with multiple styles |
| **Animation Slider** | Stunning animated sliders with images and text |
| **Info Box** | Display information with beautiful designs |
| **Call to Action** | Engaging CTA sections with images and buttons |
| **Tabs** | Vertical and horizontal tabs with rich options |
| **Countdown** | Timer countdown for events, sales, launches |
| **Dual Heading** | Headlines with 2 different styles |
| **Team Members** | Showcase your team with style |
| **Timeline** | Horizontal and vertical timeline displays |
| **Accordion** | Collapsible content sections for FAQs |
| **Progress Bar** | Animated skill bars and progress indicators |
| **Pricing Table** | Beautiful pricing comparison tables |
| **Testimonials** | Customer reviews and testimonials |
| **Data Table** | Responsive data tables |
| **Flip Box** | Interactive flip card animations |
| **Image Comparison** | Before/after image slider |
| **Mailchimp** | Newsletter subscription forms |
| **Nav Menu** | Custom navigation menus |
| **And 40+ more...** | [See all widgets →](https://magic.wpcolors.net/) |

### 🚀 Premium Features (Free!)

#### 🎬 GSAP Scroll Animations
Transform your website with professional scroll-triggered animations powered by GSAP (GreenSock Animation Platform).

- **30+ Preset Animations** - Fade, slide, zoom, flip, bounce, rotate, elastic effects
- **Text Animations** - Typewriter, split characters, wave effect, text reveal
- **Image Animations** - Parallax, ken burns, blur in, 3D tilt effects
- **Background Animations** - Parallax scroll, gradient shift, color morph
- **ScrollTrigger Support** - Customize trigger positions
- **No Coding Required** - Just select element → Advanced Tab → Magical GSAP Animation

#### 🎨 Custom CSS
Add custom CSS to any Elementor widget without coding knowledge.

#### 🏷️ Custom Attributes
Add custom HTML attributes to Elementor elements for advanced functionality.

#### 📜 Custom Code (Entire Site)
Add custom code snippets to header, footer, or body with syntax highlighting.

#### 🔀 Conditional Display
Show/hide elements based on:
- User roles and login status
- Device type (desktop, tablet, mobile)
- Date and time
- Browser type
- And more...

#### 👥 Role Manager
Control which user roles can access Elementor and Magical Addons features.

### 🏗️ Header & Footer Builder
Build custom headers and footers with Elementor - completely free!

- Works with any theme
- Full Elementor design capabilities
- Mobile responsive
- No coding required

### 📚 Template Library
Access 100+ pre-designed sections and blocks:
- Hero sections
- Feature sections
- Testimonial layouts
- Pricing tables
- Call to action blocks
- And growing weekly!

### 🎯 1600+ Premium Icons
Line Awesome icon library included for beautiful, scalable icons.

---

## 📦 Installation

### From WordPress Dashboard
1. Go to **Plugins → Add New**
2. Search for "Magical Addons for Elementor"
3. Click **Install Now** and then **Activate**

### Manual Installation
1. Download the plugin from [WordPress.org](https://wordpress.org/plugins/magical-addons-for-elementor/)
2. Upload to `/wp-content/plugins/magical-addons-for-elementor/`
3. Activate through the **Plugins** menu

### Requirements
- WordPress 5.0 or higher
- PHP 5.6 or higher
- Elementor (free version) installed and activated

---

## 🛠️ Development

### Tech Stack
- **Admin Panel**: React.js with @wordpress/scripts
- **State Management**: @wordpress/data
- **UI Components**: @wordpress/components
- **Routing**: react-router-dom
- **REST API**: WordPress REST API

### Building from Source

```bash
# Navigate to admin-react folder
cd assets/admin-react

# Install dependencies
npm install

# Development build with watch
npm run start

# Production build
npm run build
```

### File Structure

```
magical-addons-for-elementor/
├── assets/
│   ├── admin-react/          # React admin panel
│   │   ├── src/
│   │   │   ├── components/   # React components
│   │   │   ├── store/        # Redux-like store
│   │   │   └── styles/       # CSS styles
│   │   └── build/            # Compiled assets
│   ├── css/                  # Frontend styles
│   ├── js/                   # Frontend scripts
│   └── widget-assets/        # Widget-specific assets
├── includes/
│   ├── admin/                # Admin functionality
│   ├── basic/                # Core functions
│   ├── extra/                # Extra features
│   └── widgets/              # Elementor widgets
├── libs/                     # Third-party libraries
└── languages/                # Translation files
```

---

## 🔄 Changelog

### 1.4.0 (Latest)
- ✨ **NEW**: Modern React-based Admin Dashboard
- ✨ **NEW**: Recommended Plugins tab with one-click install & activate
- ✨ **NEW**: Dashboard welcome notice for wp-admin
- ✅ Added Project Details widget to widget manager
- ✅ Improved Header & Footer builder with "Open Theme Builder" quick link
- ✅ Updated Dashboard with quick links (Support, Feature Request, Rate Us)
- 🐛 Fixed Mailchimp API key not loading issue
- 🐛 Fixed Mailchimp SVG icon display issue
- 🔧 Enhanced Role Manager with free/pro capability badges
- 🔒 Improved code security (nonce, escaping, sanitization)
- 🌐 All admin text strings are now translatable
- ⚡ Performance improvements and code optimization

### 1.3.15
- ✨ **NEW**: GSAP Scroll Animations with 30+ presets
- Added text, image, and background animations
- ScrollTrigger support with customizable positions
- Admin notice for GSAP feature announcement

[View full changelog →](https://wordpress.org/plugins/magical-addons-for-elementor/#developers)

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📞 Support

- **WordPress.org Support**: [Forum](https://wordpress.org/support/plugin/magical-addons-for-elementor/)
- **Feature Requests**: [Contact Us](https://wpthemespace.com/contact-us/)
- **Documentation**: [Docs](https://developer.developer/#)

---

## ⭐ Rate Us

If you find this plugin helpful, please consider leaving a [5-star review](https://wordpress.org/support/plugin/magical-addons-for-elementor/reviews/?filter=5) on WordPress.org. It helps us continue improving the plugin!

---

## 📄 License

This project is licensed under the GPL-2.0+ License - see the [LICENSE](LICENSE.txt) file for details.

---

## 👨‍💻 Author

**Starter developer**

- Website: [wpthemespace.com](https://wpthemespace.com)
- WordPress: [@nalam](https://profiles.wordpress.org/nalam/)

---

<p align="center">
  Made with ❤️ for the WordPress community
</p>
