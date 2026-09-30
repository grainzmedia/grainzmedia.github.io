#!/usr/bin/env bash
# Generates responsive WebP + JPEG renditions (and photos/manifest.json) from the masters in tools/photos.
#   bash tools/images.sh
# Requires ImageMagick 7 (`magick`) built with WebP support.
set -euo pipefail
cd "$(dirname "$0")/.."
SRC=tools/photos
OUT=assets/img/photos
mkdir -p "$OUT"

echo "{" > "$OUT/manifest.json"
first=1
for f in "$SRC"/*.jpg; do
  name=$(basename "$f" .jpg)
  read -r W H < <(magick identify -format "%w %h\n" "$f")
  widths=()
  for w in 640 1024 1600 2400; do
    [ "$W" -ge "$w" ] && widths+=("$w")
  done
  # always include the master width so nothing is upscaled from a smaller rendition
  if [ ${#widths[@]} -eq 0 ] || [ "${widths[${#widths[@]}-1]}" -lt "$W" ]; then widths+=("$W"); fi
  for w in "${widths[@]}"; do
    magick "$f" -resize "${w}x>" -strip -interlace Plane -sampling-factor 4:2:0 -quality 78 "$OUT/$name-$w.jpg"
    magick "$f" -resize "${w}x>" -strip -quality 76 -define webp:method=6 "$OUT/$name-$w.webp"
  done
  [ $first -eq 0 ] && echo "," >> "$OUT/manifest.json"
  first=0
  list=$(IFS=,; echo "${widths[*]}")
  printf '  "%s": {"width": %s, "height": %s, "widths": [%s]}' "$name" "$W" "$H" "$list" >> "$OUT/manifest.json"
done
printf '\n}\n' >> "$OUT/manifest.json"
echo "done → $OUT"
