# Design Spec: Gallery Lightbox Upgrade

## Goal
Improve the gallery lightbox of Cuerpo Libre to display high-resolution images (instead of small thumbnails) and transition the user experience into a premium, dark glassmorphic interface with floating controls, swipe gestures, and elegant captions.

## Current Architecture
- **HTML**: Standard container `div#cl-lightbox` in [footer.php](file:///home/gato/Proyectos/cuerpolibre/wp-content/themes/cuerpolibre/footer.php) with an inner `cl-lightbox-content` wrapper containing the `img#lightboxImg` and a close button `lightboxClose`.
- **CSS**: Custom style block in [style.css](file:///home/gato/Proyectos/cuerpolibre/wp-content/themes/cuerpolibre/style.css) (lines 2366-2480).
- **JavaScript**: A script section in [js/main.js](file:///home/gato/Proyectos/cuerpolibre/wp-content/themes/cuerpolibre/js/main.js) (lines 230-345) that hooks click events on all page images inside specific gallery classes, grabs their `src`, and toggles the lightbox.

## Proposed Design Changes

### 1. JavaScript Resolution Enhancer
- When parsing gallery images for the lightbox list, we will look for:
  1. WordPress block attributes (`data-full-url`, `data-large-file`, etc.).
  2. Parent link tags wrapping the images (`<a>` elements pointing directly to image files).
  3. The `srcset` attribute, parsing it to retrieve the highest resolution option.
  4. Suffix removal fallback: regex stripping size indicators like `-1024x768.jpg` or `-300x200.jpg` from the `src` to fallback directly to the original file.
- Update `openLightbox` and `updateLightbox` functions to dynamically display high-resolution URLs.

### 2. UI Layout & Sizing (CSS)
- **Glassmorphism Backdrop**: Adjust the overlay backdrop to `background: rgba(5, 5, 5, 0.95)` and `backdrop-filter: blur(16px)` to create a premium depth effect.
- **Image Sizing**: Adapt the image container and `img` to display as large as possible. Make the image use `max-width: 95vw; max-height: 90vh; width: auto; height: auto; object-fit: contain;` so it automatically expands to fill the viewport while retaining its aspect ratio.
- **Close Button**: Move the close button to the top-right corner of the viewport (outside the image container) so it never clips or overlaps the image content. Make it a styled circle with a subtle background and hover transitions.
- **Navigation Controls**: Style prev/next buttons as minimalist floating circles on the sides of the screen.
- **Captions**: Center the image `alt` text at the bottom of the screen below the image, using serif typography (`var(--font-serif)`) and warm gold (`var(--accent)`).

### 3. Touch Gestures (Mobile swipe)
- Integrate a lightweight swipe detection listener to support swipe-left (next) and swipe-right (prev) interactions.

## Verification Plan
- **Manual verification**: Click on images within various gallery layouts (masonry, single image blocks) to verify high resolution loading and proper scaling.
- **Responsive checks**: Test responsiveness across desktop, tablet, and mobile dimensions.
- **Interaction checks**: Verify keyboard navigation (arrow keys, Escape), side button clicking, swipe gestures, and outside-clicks closing the lightbox.
