# Flat-file content store
# ========================
#
# Source of truth for site content when FLAT_CONTENT=true.
# form_results + admin_* always stay in MySQL.
#
# Workflow
# --------
# 1) Export from MySQL (keep MySQL as backup):
#      php artisan flat:export-from-db --rebuild-index
#
# 2) Verify counts:
#      php artisan flat:verify
#
# 3) Enable in .env:
#      FLAT_CONTENT=true
#
# 4) Clear caches / restart PHP-FPM
#
# 5) Smoke-test checklist (1:1):
#    [ ] Landing resolves brand by domain
#    [ ] Homepage + text_block() content
#    [ ] Meta / OG / FAQ JSON-LD on parts_main
#    [ ] Categories / products / articles / menus
#    [ ] Form submit → form_results in MySQL + email
#    [ ] Admin login works
#    [ ] Admin Brand edit saves and updates content/brands/{slug}/
#    [ ] Admin form_results list still shows submissions
#
# 6) Rollback: FLAT_CONTENT=false (MySQL content untouched)
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
#   content/forms/{id}.json          (form + fields)
#   content/category_brands.json
#
# After editing files by hand/AI:
#      php artisan flat:build-index
#
