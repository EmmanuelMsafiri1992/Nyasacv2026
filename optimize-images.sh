#!/bin/bash

# ============================================
# NYASACV Image Optimization Script
# Optimizes images for faster loading
# ============================================

echo "==================================="
echo "NYASACV Image Optimization Script"
echo "==================================="
echo ""

# Check if imagemagick is installed
if ! command -v convert &> /dev/null; then
    echo "ImageMagick is not installed. Installing..."
    # Uncomment the line below if you want to auto-install (requires sudo)
    # sudo yum install -y ImageMagick
    echo "Please install ImageMagick first:"
    echo "  sudo yum install -y ImageMagick"
    exit 1
fi

# Directories to optimize
IMAGES_DIR="./public/images"
IMG_DIR="./public/img"

# Create backup directory
BACKUP_DIR="./image_backups_$(date +%Y%m%d_%H%M%S)"
echo "Creating backup in $BACKUP_DIR..."
mkdir -p "$BACKUP_DIR"

# Function to optimize images
optimize_images() {
    local dir=$1
    local total=0
    local optimized=0

    echo "Optimizing images in $dir..."

    # Find all image files
    while IFS= read -r -d '' file; do
        ((total++))

        # Get file size before
        size_before=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file" 2>/dev/null)

        # Create backup
        cp "$file" "$BACKUP_DIR/"

        # Get file extension
        ext="${file##*.}"
        ext_lower=$(echo "$ext" | tr '[:upper:]' '[:lower:]')

        # Optimize based on file type
        case $ext_lower in
            jpg|jpeg)
                convert "$file" -strip -interlace Plane -quality 85 -sampling-factor 4:2:0 "$file.tmp" && mv "$file.tmp" "$file"
                ;;
            png)
                convert "$file" -strip -define png:compression-level=9 "$file.tmp" && mv "$file.tmp" "$file"
                ;;
            gif)
                convert "$file" -strip -layers optimize "$file.tmp" && mv "$file.tmp" "$file"
                ;;
            *)
                continue
                ;;
        esac

        # Get file size after
        size_after=$(stat -f%z "$file" 2>/dev/null || stat -c%s "$file" 2>/dev/null)

        # Calculate savings
        if [ $size_after -lt $size_before ]; then
            savings=$((size_before - size_after))
            savings_kb=$((savings / 1024))
            echo "  ✓ Optimized: $(basename "$file") - Saved ${savings_kb}KB"
            ((optimized++))
        fi

    done < <(find "$dir" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" -o -iname "*.gif" \) -print0)

    echo "  Total: $total images, Optimized: $optimized images"
    echo ""
}

# Optimize images in both directories
if [ -d "$IMAGES_DIR" ]; then
    optimize_images "$IMAGES_DIR"
else
    echo "Directory $IMAGES_DIR not found, skipping..."
fi

if [ -d "$IMG_DIR" ]; then
    optimize_images "$IMG_DIR"
else
    echo "Directory $IMG_DIR not found, skipping..."
fi

echo "==================================="
echo "Optimization Complete!"
echo "Backups saved in: $BACKUP_DIR"
echo "==================================="
echo ""
echo "Next steps:"
echo "1. Test your website to ensure images load correctly"
echo "2. Clear your browser cache"
echo "3. If everything works, you can delete the backup: rm -rf $BACKUP_DIR"
echo ""
