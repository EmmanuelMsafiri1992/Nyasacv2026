# NyasaCV Security Configuration

## Last Updated: 2025-12-26

## Security Incident Summary
On December 22, 2025, a phishing file was uploaded to the server via an exposed `.git` directory.
This document outlines the security measures implemented to prevent future incidents.

---

## Deployment Checklist

### CRITICAL - Before Every Deployment:

```
[ ] Remove .git directory from server after deployment
    Command: rm -rf /home/indegnnk/nyasacv.com/.git

[ ] Verify .htaccess files are uploaded:
    - /.htaccess (root)
    - /public/.htaccess
    - /app/.htaccess
    - /bootstrap/.htaccess
    - /config/.htaccess
    - /database/.htaccess
    - /resources/.htaccess
    - /routes/.htaccess
    - /storage/.htaccess
    - /vendor/.htaccess
    - /tests/.htaccess

[ ] Set correct file permissions:
    find /home/indegnnk/nyasacv.com -type f -exec chmod 644 {} \;
    find /home/indegnnk/nyasacv.com -type d -exec chmod 755 {} \;
    chmod 600 /home/indegnnk/nyasacv.com/.env

[ ] Verify sensitive URLs return 403 Forbidden:
    - https://nyasacv.com/.git/config (should be 403)
    - https://nyasacv.com/.env (should be 403)
    - https://nyasacv.com/resources/ (should be 403)
    - https://nyasacv.com/app/ (should be 403)
    - https://nyasacv.com/config/ (should be 403)
    - https://nyasacv.com/vendor/ (should be 403)
```

---

## Protected Directories

The following directories are blocked from web access:

| Directory | Contains | Protection |
|-----------|----------|------------|
| /app | Application code | .htaccess + RewriteRule |
| /bootstrap | Framework bootstrap | .htaccess + RewriteRule |
| /config | Configuration files | .htaccess + RewriteRule |
| /database | Migrations, seeds | .htaccess + RewriteRule |
| /resources | Views, lang files | .htaccess + RewriteRule |
| /routes | Route definitions | .htaccess + RewriteRule |
| /storage | Logs, cache, uploads | .htaccess + RewriteRule |
| /vendor | Composer packages | .htaccess + RewriteRule |
| /tests | Test files | .htaccess + RewriteRule |
| /.git | Git repository | .htaccess + RewriteRule |

---

## Protected Files

These files are blocked from web access:

- `.env` and `.env.*` - Environment variables
- `.git*` - Git configuration
- `composer.json/lock` - Dependency information
- `package.json/lock` - NPM dependencies
- `artisan` - Laravel CLI
- `*.sql`, `*.bak`, `*.log` - Database/backup files
- `*.phtml`, `*.pht`, `*.php3-7` - Alternative PHP extensions

---

## Security Headers

The following security headers are set:

```
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Referrer-Policy: strict-origin-when-cross-origin
Permissions-Policy: geolocation=(), microphone=(), camera=()
```

---

## Post-Deployment Verification Script

Run this after each deployment:

```bash
#!/bin/bash
DOMAIN="nyasacv.com"

echo "Testing security..."

# Test .git block
STATUS=$(curl -s -o /dev/null -w "%{http_code}" "https://$DOMAIN/.git/config")
if [ "$STATUS" = "403" ]; then
    echo "[PASS] .git blocked"
else
    echo "[FAIL] .git accessible! Status: $STATUS"
fi

# Test .env block
STATUS=$(curl -s -o /dev/null -w "%{http_code}" "https://$DOMAIN/.env")
if [ "$STATUS" = "403" ]; then
    echo "[PASS] .env blocked"
else
    echo "[FAIL] .env accessible! Status: $STATUS"
fi

# Test resources block
STATUS=$(curl -s -o /dev/null -w "%{http_code}" "https://$DOMAIN/resources/")
if [ "$STATUS" = "403" ]; then
    echo "[PASS] /resources blocked"
else
    echo "[FAIL] /resources accessible! Status: $STATUS"
fi

# Test app block
STATUS=$(curl -s -o /dev/null -w "%{http_code}" "https://$DOMAIN/app/")
if [ "$STATUS" = "403" ]; then
    echo "[PASS] /app blocked"
else
    echo "[FAIL] /app accessible! Status: $STATUS"
fi

echo "Security test complete."
```

---

## Emergency Response

If you receive another abuse notice:

1. **Immediately** check the reported URL
2. Delete suspicious files
3. Check cPanel access logs: `cat /usr/local/cpanel/logs/access_log | grep indegnnk | tail -100`
4. Check for recent file changes: `find /home/indegnnk/nyasacv.com -mtime -7 -type f`
5. Change all passwords
6. Contact Namecheap with resolution details

---

## Password Rotation Schedule

Change these passwords regularly:

- [ ] cPanel password
- [ ] Database password
- [ ] Email account passwords
- [ ] API keys in .env
- [ ] Enable 2FA on all accounts

---

## Contact

For security issues, contact the development team immediately.
