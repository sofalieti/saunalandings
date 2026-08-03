# Flat-file content store
# ========================
#
# Source of truth for site content when FLAT_CONTENT=true.
# form_results + admin_* always stay in MySQL.
# SQLite (storage/flat/content.sqlite) is a local index only — do not edit or commit it.
#
# Day-to-day workflow (local ↔ server)
# ------------------------------------
# 1) Edit JSON files locally (e.g. brands/{slug}/text_blocks/{id}.json → description).
#
# 2) Commit and push to main:
#
#      git add content
#      git commit -m "Update Active Forever repair text"
#      git push
#
# 3) GitHub Actions (automatic — no server terminal):
#      push main → Checks (composer / php -l / scripts/ci-check.php)
#               → if OK → SSH → git pull on the server
#      Index rebuilds on the next HTTP request (FLAT_AUTO_REBUILD=true).
#
# GitHub Actions secrets (repo → Settings → Secrets and variables → Actions)
# -------------------------------------------------------------------------
#   SSH_HOST         server hostname or IP
#   SSH_USER         SSH user (e.g. root)
#   SSH_PRIVATE_KEY  private key paired with server authorized_keys
#   SSH_PORT         optional, default 22
#   DEPLOY_PATH      /var/www/www-root/data/www/activeforeversaunaparts.com
#
# One-time on the server: add the CI public key to ~/.ssh/authorized_keys
# and ensure `git pull` works without a password for that user.
#
# Local CI (same as Actions check job):
#      php scripts/ci-check.php
#
# Manual server pull (only if Actions deploy is not configured yet):
#      git pull
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
