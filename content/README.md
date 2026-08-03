# Flat-file content store
# ========================
#
# Source of truth for site content when FLAT_CONTENT=true.
# form_results + admin_* always stay in MySQL.
# SQLite (storage/flat/content.sqlite) is a local index only — do not edit or commit it.
#
# Day-to-day workflow (local ↔ server)
# ------------------------------------
# 1) One-time: copy content/ from the server to your machine:
#
#      rsync -avz --progress \
#        user@server:/var/www/www-root/data/www/activeforeversaunaparts.com/content/ \
#        ./content/
#
#    Or download a tarball of content/ and unpack into ./content/
#
# 2) Edit JSON files locally (e.g. brands/{slug}/text_blocks/{id}.json → description).
#
# 3) Commit and push content/ with the rest of the repo:
#
#      git add content
#      git commit -m "Update Active Forever repair text"
#      git push
#
# 4) On the server: git pull only.
#    Index rebuilds automatically on the next HTTP request (FLAT_AUTO_REBUILD=true).
#    Optional once on the server for even faster pulls:
#      git config core.hooksPath githooks
#
# First-time export from MySQL (already done if content/ exists on server)
# -----------------------------------------------------------------------
#      php artisan flat:export-from-db --rebuild-index
#      php artisan flat:verify
#      # .env: FLAT_CONTENT=true
#
# Layout (AI-editable)
# --------------------
#   content/sites/{id}.json
#   content/brands/{slug}/brand.json
#   content/brands/{slug}/seo.json
#   content/brands/{slug}/faq.json
#   content/brands/{slug}/states.json
#   content/brands/{slug}/model_lines.json
#   content/brands/{slug}/text_blocks/{id}.json
#   content/brands/{slug}/feature_values/{id}.json
#   content/categories|products|articles|menus|.../{id}.json
#   content/forms/{id}.json
#   content/category_brands.json
#
# Manual rebuild (only if auto-rebuild is off)
# --------------------------------------------
#      php artisan flat:build-index
#
# Rollback
# --------
#      FLAT_CONTENT=false   # MySQL content still there as backup
#
