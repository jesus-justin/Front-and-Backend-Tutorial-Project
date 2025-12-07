<?php
// Fallback data shown when the database is not reachable.
return [
    ['area' => 'frontend', 'stage' => 'basic', 'title' => 'Semantic Layout', 'summary' => 'Craft HTML5 skeletons with landmarks (header, nav, main, footer) and meaningful tags for accessibility.', 'demo' => 'Focus on structure before style; use ARIA labels only when needed.', 'callout' => 'HTML + CSS fundamentals'],
    ['area' => 'frontend', 'stage' => 'basic', 'title' => 'Styling Essentials', 'summary' => 'Control spacing, color tokens, and the box model with modern CSS (flex, clamp, custom properties).', 'demo' => 'Build a responsive card using flexbox and consistent spacing scale.', 'callout' => 'Flexbox + scale'],
    ['area' => 'frontend', 'stage' => 'basic', 'title' => 'DOM Events', 'summary' => 'Listen to clicks, keyboard events, and form submissions; keep handlers small and declarative.', 'demo' => 'Toggle highlight on cards via event delegation.', 'callout' => 'Vanilla JS'],

    ['area' => 'backend', 'stage' => 'basic', 'title' => 'HTTP & Routing', 'summary' => 'Map URLs to responses, set headers, and return clean JSON or HTML.', 'demo' => 'Serve a GET endpoint that returns the exhibits list.', 'callout' => 'Routes + headers'],
    ['area' => 'backend', 'stage' => 'basic', 'title' => 'Database Reads', 'summary' => 'Use parameterized queries to fetch rows safely and return typed arrays.', 'demo' => 'PDO with prepared statements and utf8mb4.', 'callout' => 'SQL hygiene'],
    ['area' => 'backend', 'stage' => 'basic', 'title' => 'Input Validation', 'summary' => 'Validate incoming params, normalize casing, and guard against missing data.', 'demo' => 'Filter_input with defaults; short-circuit on errors.', 'callout' => 'Safety first'],

    ['area' => 'frontend', 'stage' => 'intermediate', 'title' => 'Responsive Systems', 'summary' => 'Compose fluid grids, clamp() typography, and layout tokens for tablet/desktop.', 'demo' => 'Grid cards that reflow from 1 to 2 to 3 columns.', 'callout' => 'CSS Grid'],
    ['area' => 'frontend', 'stage' => 'intermediate', 'title' => 'Fetching JSON', 'summary' => 'Call APIs with fetch(), handle loading states, and render optimistic UI.', 'demo' => 'Refresh the exhibits list and animate card entry.', 'callout' => 'fetch() + state'],
    ['area' => 'frontend', 'stage' => 'intermediate', 'title' => 'Form UX', 'summary' => 'Inline validation, accessible labels, and keyboard-friendly controls.', 'demo' => 'Mark invalid fields, announce errors with aria-live.', 'callout' => 'A11y-first'],

    ['area' => 'backend', 'stage' => 'intermediate', 'title' => 'REST Patterns', 'summary' => 'Design predictable URLs, verbs, and status codes; document the contract.', 'demo' => 'GET /exhibits?stage=basic returns filtered rows.', 'callout' => 'API hygiene'],
    ['area' => 'backend', 'stage' => 'intermediate', 'title' => 'Sessions & Auth', 'summary' => 'Manage logins with sessions, hashed passwords, and CSRF tokens.', 'demo' => 'Session middleware that guards private routes.', 'callout' => 'State + security'],
    ['area' => 'backend', 'stage' => 'intermediate', 'title' => 'Logging & Metrics', 'summary' => 'Structured logs, correlation IDs, and minimal request timing.', 'demo' => 'Log request path, duration, and status code.', 'callout' => 'Observability'],

    ['area' => 'frontend', 'stage' => 'advanced', 'title' => 'Performance & Media', 'summary' => 'Lazy-load heavy assets, use prefers-reduced-motion, and prefetch critical CSS.', 'demo' => 'IntersectionObserver to fade cards in as they scroll.', 'callout' => 'Perf mindset'],
    ['area' => 'frontend', 'stage' => 'advanced', 'title' => 'State & Data Shapes', 'summary' => 'Normalize data, derive UI state, and avoid prop-drilling with event buses.', 'demo' => 'Central store drives filters and badges.', 'callout' => 'Data flow'],
    ['area' => 'frontend', 'stage' => 'advanced', 'title' => 'Testing the UI', 'summary' => 'Design testable components, write assertions for accessibility and flows.', 'demo' => 'Cypress-style plan for navigation and filters.', 'callout' => 'Quality gates'],

    ['area' => 'backend', 'stage' => 'advanced', 'title' => 'Caching & Pagination', 'summary' => 'Paginate queries, add micro-caches, and expose Link headers.', 'demo' => 'Cache exhibits query per filter for 30 seconds.', 'callout' => 'Speed + scale'],
    ['area' => 'backend', 'stage' => 'advanced', 'title' => 'Background Work', 'summary' => 'Queue non-critical tasks and retry failures with backoff.', 'demo' => 'Queue email digest after content updates.', 'callout' => 'Asynchronicity'],
    ['area' => 'backend', 'stage' => 'advanced', 'title' => 'File Handling', 'summary' => 'Accept uploads, sanitize names, scan types, and store metadata.', 'demo' => 'Upload handler with mime/size caps and checksum.', 'callout' => 'Safety + IO'],

    ['area' => 'frontend', 'stage' => 'master', 'title' => 'Design Systems', 'summary' => 'Token-driven colors, spacing, and motion with consistent components.', 'demo' => 'Composable card primitives with variants.', 'callout' => 'Systems thinking'],
    ['area' => 'frontend', 'stage' => 'master', 'title' => 'Progressive Enhancement', 'summary' => 'Ship core HTML first, then layer JS, fallbacks, and offline hints.', 'demo' => 'Cards readable without JS; filters enhance UX.', 'callout' => 'Resilience'],
    ['area' => 'frontend', 'stage' => 'master', 'title' => 'Observability in UI', 'summary' => 'Trace user journeys, feature flags, and experiment responsibly.', 'demo' => 'Instrument filter usage and clicks.', 'callout' => 'Product thinking'],

    ['area' => 'backend', 'stage' => 'master', 'title' => 'Domain Design', 'summary' => 'Model capabilities as aggregates, enforce invariants, and keep use-cases explicit.', 'demo' => 'Use services to wrap DB calls and validation.', 'callout' => 'DDD-lite'],
    ['area' => 'backend', 'stage' => 'master', 'title' => 'Resilience & Recovery', 'summary' => 'Health checks, graceful degradation, and circuit breakers.', 'demo' => 'Detect DB outage and fall back to cached data.', 'callout' => 'Reliability'],
    ['area' => 'backend', 'stage' => 'master', 'title' => 'Security Posture', 'summary' => 'Rotate secrets, audit access, and sanitize every boundary.', 'demo' => 'Principle of least privilege, audit tables.', 'callout' => 'Trust but verify'],
];
