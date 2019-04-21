# Plugin Backend
  - Form
    - API Key
    - Site
    - Listing Keys
      - Textarea (comma OR newline separated)
    - Template (Mustache)

# Scripts
- Dependency script (enqueued): bundles jQuery + Mustache + slider + API client + Plugin client, under `SpringSlider` namespace
- Slider script (injected by shortcode): Creates DOM node -> invokes plugin client

