# Excoso — Website + Live Admin Panel

A static site (hosted free on GitHub Pages) with a real, live-editing admin
panel powered by Firebase. No PHP, no server to maintain, no manual file
uploads to publish a change — edit a product in the admin panel and it's
live on the site as soon as the page is refreshed.

The admin panel is a small internal CRM: a **Dashboard** with live counts,
**Categories**/**Products** management with search, filtering, sorting, an
Active/Inactive status, and image uploads (via Firebase Storage — see step
5 below), a **Quotes** pipeline (New → Qualified → Contacted → Quotation
Sent → Won/Lost, with notes and follow-up dates), and **Settings** for
your company's contact info.

## What's here

```
index.html              Homepage (hero carousel, categories, "The Edit", quote form)
catalog.html             Full browsable catalog with category filters + search
css/style.css             All styling for the public site
js/catalog.js             Loads categories/products (from Firestore, or the
                           bundled data/catalog.json as a fallback) and renders
                           every dynamic section of index.html and catalog.html
js/main.js                Carousel, mobile nav, search box, quote form handling
js/firebase-config.js     Shared Firebase project config — YOU fill this in
data/catalog.json         Starter/fallback catalog data (6 sample categories
                           and products) — also used by the admin panel's
                           "Import Starter Catalog" button
images/                   Logo + the one real product photo bundled
admin/index.html           The admin panel itself (login + dashboard)
admin/admin.css            Admin panel styling
admin/js/main.js           Login form, auth state, logout, tab switching
admin/js/core.js           Shared helpers: slug/money/esc, modal, toast, confirm dialog
admin/js/storage.js        Firebase Storage upload/delete helper (images)
admin/js/dashboard.js      Dashboard tab — live product/category/quote counts
admin/js/categories.js     Categories tab (add/edit/delete/search + seed import)
admin/js/products.js       Products tab (search, filter, sort, status, image upload)
admin/js/quotes.js         Quotes CRM (status pipeline, search, notes, follow-up date)
admin/js/settings.js       Settings tab — company info stored in Firestore
firestore.rules            Firestore security rules to paste into the console
                            (public read for the catalog & settings, public
                            create-only for quotes, admin-only for everything else)
storage.rules               Firebase Storage security rules (product/category
                            images — public read, admin-only write, 5MB/image cap)
```

## How it works

- **The public site** (`index.html`, `catalog.html`) reads categories and
  products from a Firestore database at page-load time. If Firebase hasn't
  been configured yet (see below) or Firestore is empty, it automatically
  falls back to the bundled `data/catalog.json` so the site is never blank.
- **The admin panel** (`admin/index.html`) requires a real login (Firebase
  Authentication) and writes directly to that same Firestore database.
  Nothing to download, move into a folder, or `git push` — saving a change
  in the admin panel *is* publishing it.
- Both the public site and the admin panel are just static HTML/CSS/JS —
  Firebase's SDK runs entirely in the visitor's/your browser and talks
  directly to Google's servers. That's why this still works perfectly on
  GitHub Pages, which can only serve static files.

---

## One-time setup (do this before anything works)

### 1. Create a Firebase project

1. Go to **[console.firebase.google.com](https://console.firebase.google.com)** and sign in with any Google account.
2. Click **Add project**, name it (e.g. `excoso`), and finish the wizard
   (Google Analytics is optional — you can skip it). The free **Spark**
   plan is all you need; no credit card required.

### 2. Register a web app and get your config

1. In the project, click the **gear icon → Project settings**.
2. Under "Your apps," click the **web icon (`</>`)**.
3. Give it any nickname (e.g. "excoso-site"). Leave "Also set up Firebase
   Hosting" **unchecked** — you're using GitHub Pages instead.
4. It will show a `firebaseConfig` object. Copy those values into
   **`js/firebase-config.js`** in this project, replacing the placeholder
   `"YOUR_API_KEY"` etc. values. These values are not secret — it's normal
   for them to be visible in public site code; real security comes from
   Authentication + the security rules in step 4 below.

### 3. Turn on Authentication and create your one admin login

1. In the left sidebar: **Build → Authentication → Get started**.
2. Under "Sign-in method," enable **Email/Password**.
3. Go to the **Users** tab → **Add user** → enter the email and password
   you want to log into the admin panel with. That's it — no separate
   "registration" flow, you just create yourself directly here.

### 4. Turn on Firestore and paste in the security rules

1. In the left sidebar: **Build → Firestore Database → Create database**.
2. Choose **Start in production mode**, pick any location close to you, click **Enable**.
3. Go to the **Rules** tab, delete what's there, and paste in the entire
   contents of **`firestore.rules`** from this project. Click **Publish**.
   (This makes categories/products publicly readable but only writable by
   your logged-in admin account — see the comments in that file.)

### 5. Turn on Storage and paste in its security rules (for image uploads)

Product and category photo *uploads* (as opposed to pasting an existing
image URL, which still works without this) need Firebase Storage, which
requires the pay-as-you-go **Blaze** plan — the free Spark plan doesn't
include Storage for new projects. Blaze still has a generous free monthly
allowance (5GB stored, 1GB/day downloaded); for a small internal catalog
you're very unlikely to be charged anything.

1. In the left sidebar: **Build → Storage → Get started**. If prompted,
   upgrade to the **Blaze** plan (you can set a budget alert).
2. Accept the default bucket location and click **Done**.
3. Go to the **Rules** tab, delete what's there, and paste in the entire
   contents of **`storage.rules`** from this project. Click **Publish**.

If you'd rather skip this for now, everything still works — just paste
image URLs (a link to an already-hosted photo) in the product/category
forms instead of using the "Choose File" upload button.

### 6. Load your starter data

1. Open `admin/index.html` in a browser (once this is deployed — see
   below — or locally via `python3 -m http.server`; opening it directly as
   a `file://` URL won't work because it needs to `fetch()` a JSON file).
2. Log in with the email/password you created in step 3.
3. Click **Import Starter Catalog**. This loads the 6 sample
   categories/products from `data/catalog.json` into Firestore so you have
   something real to edit. Safe to click again later — it skips anything
   that already exists.
4. Edit, add, or delete categories and products from here on.

---

## Deploying to GitHub Pages

1. Push this whole folder to a GitHub repository (`git init`, `git add -A`,
   `git commit -m "Initial site"`, create a repo on GitHub, `git push`).
2. In the repo: **Settings → Pages** → under "Build and deployment," set
   Source to **Deploy from a branch**, branch **main**, folder **/ (root)**.
   Save.
3. GitHub gives you a URL like `https://yourusername.github.io/reponame/`
   within a minute or two — confirm the site and `/admin/` both load there
   before moving to the domain step.

## Connecting your GoDaddy domain (excoso.in)

Same DNS approach as before — in GoDaddy's DNS management for excoso.in:

1. Add four **A** records, all with Name `@`, pointing to GitHub Pages' IPs:
   `185.199.108.153`, `185.199.109.153`, `185.199.110.153`, `185.199.111.153`.
2. Add a **CNAME** record, Name `www`, pointing to `yourusername.github.io.`
3. In the GitHub repo: **Settings → Pages → Custom domain**, enter
   `excoso.in`, Save. Wait for the DNS check to pass (can take a little
   time to propagate), then tick **Enforce HTTPS** once it's available.

## The "Get a Quote" form

Once Firebase is configured (steps above), submissions save straight into
Firestore's `quotes` collection — the visitor sees an inline "Thanks,
we'll be in touch" message, no email app popup, no extra service to set
up. Check them in the admin panel's **Quotes** tab, which shows every
field submitted, badges how many are unhandled, and lets you mark each
one as contacted or delete it.

If Firebase *hasn't* been configured yet, the form automatically falls
back to opening the visitor's email app instead (same as before), so it
still works even before you've done the Firebase setup.

## If something won't load

- **Public site shows the fallback data instead of your real catalog:**
  double-check `js/firebase-config.js` has your real values (not the
  `"YOUR_API_KEY"` placeholders), and that `firestore.rules` has been
  published in the Firebase console.
- **Admin panel says "Firebase isn't configured yet":** same fix — the
  config file hasn't been filled in.
- **Login fails with "incorrect email or password":** double check the
  user you created in Authentication → Users, not a guess — there's no
  password reset flow wired up here, so re-create the user in the console
  if needed.
- **Image upload says Storage isn't set up / silently does nothing:**
  Storage needs the Blaze plan and its own `storage.rules` published (see
  step 5 above). Until then, paste an image URL instead — that field
  always works regardless of Storage.
- **Deleting a category is refused:** by design — it tells you how many
  products still use it. Reassign or delete those products first, or
  leave the category in place.
