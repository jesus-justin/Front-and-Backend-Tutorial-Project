CREATE DATABASE IF NOT EXISTS dev_museum CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dev_museum;

CREATE TABLE IF NOT EXISTS exhibits (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    area ENUM('frontend','backend') NOT NULL,
    stage ENUM('basic','intermediate','advanced','master') NOT NULL,
    title VARCHAR(120) NOT NULL,
    summary TEXT NOT NULL,
    demo TEXT NULL,
    callout VARCHAR(160) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO exhibits (area, stage, title, summary, demo, callout) VALUES
('frontend', 'basic', 'Semantic Layout', 'Craft HTML5 skeletons with landmarks (header, nav, main, footer) and meaningful tags for accessibility.', 'Focus on structure before style; use ARIA labels only when needed.', 'HTML + CSS fundamentals'),
('frontend', 'basic', 'Styling Essentials', 'Control spacing, color tokens, and the box model with modern CSS (flex, clamp, custom properties).', 'Build a responsive card using flexbox and consistent spacing scale.', 'Flexbox + scale'),
('frontend', 'basic', 'DOM Events', 'Listen to clicks, keyboard events, and form submissions; keep handlers small and declarative.', 'Toggle highlight on cards via event delegation.', 'Vanilla JS'),

('backend', 'basic', 'HTTP & Routing', 'Map URLs to responses, set headers, and return clean JSON or HTML.', 'Serve a GET endpoint that returns the exhibits list.', 'Routes + headers'),
('backend', 'basic', 'Database Reads', 'Use parameterized queries to fetch rows safely and return typed arrays.', 'PDO with prepared statements and utf8mb4.', 'SQL hygiene'),
('backend', 'basic', 'Input Validation', 'Validate incoming params, normalize casing, and guard against missing data.', 'Filter_input with defaults; short-circuit on errors.', 'Safety first'),

('frontend', 'intermediate', 'Responsive Systems', 'Compose fluid grids, clamp() typography, and layout tokens for tablet/desktop.', 'Grid cards that reflow from 1 to 2 to 3 columns.', 'CSS Grid'),
('frontend', 'intermediate', 'Fetching JSON', 'Call APIs with fetch(), handle loading states, and render optimistic UI.', 'Refresh the exhibits list and animate card entry.', 'fetch() + state'),
('frontend', 'intermediate', 'Form UX', 'Inline validation, accessible labels, and keyboard-friendly controls.', 'Mark invalid fields, announce errors with aria-live.', 'A11y-first'),

('backend', 'intermediate', 'REST Patterns', 'Design predictable URLs, verbs, and status codes; document the contract.', 'GET /exhibits?stage=basic returns filtered rows.', 'API hygiene'),
('backend', 'intermediate', 'Sessions & Auth', 'Manage logins with sessions, hashed passwords, and CSRF tokens.', 'Session middleware that guards private routes.', 'State + security'),
('backend', 'intermediate', 'Logging & Metrics', 'Structured logs, correlation IDs, and minimal request timing.', 'Log request path, duration, and status code.', 'Observability'),

('frontend', 'advanced', 'Performance & Media', 'Lazy-load heavy assets, use prefers-reduced-motion, and prefetch critical CSS.', 'IntersectionObserver to fade cards in as they scroll.', 'Perf mindset'),
('frontend', 'advanced', 'State & Data Shapes', 'Normalize data, derive UI state, and avoid prop-drilling with event buses.', 'Central store drives filters and badges.', 'Data flow'),
('frontend', 'advanced', 'Testing the UI', 'Design testable components, write assertions for accessibility and flows.', 'Cypress-style plan for navigation and filters.', 'Quality gates'),

('backend', 'advanced', 'Caching & Pagination', 'Paginate queries, add micro-caches, and expose Link headers.', 'Cache exhibits query per filter for 30 seconds.', 'Speed + scale'),
('backend', 'advanced', 'Background Work', 'Queue non-critical tasks and retry failures with backoff.', 'Queue email digest after content updates.', 'Asynchronicity'),
('backend', 'advanced', 'File Handling', 'Accept uploads, sanitize names, scan types, and store metadata.', 'Upload handler with mime/size caps and checksum.', 'Safety + IO'),

('frontend', 'master', 'Design Systems', 'Token-driven colors, spacing, and motion with consistent components.', 'Composable card primitives with variants.', 'Systems thinking'),
('frontend', 'master', 'Progressive Enhancement', 'Ship core HTML first, then layer JS, fallbacks, and offline hints.', 'Cards readable without JS; filters enhance UX.', 'Resilience'),
('frontend', 'master', 'Observability in UI', 'Trace user journeys, feature flags, and experiment responsibly.', 'Instrument filter usage and clicks.', 'Product thinking'),

('backend', 'master', 'Domain Design', 'Model capabilities as aggregates, enforce invariants, and keep use-cases explicit.', 'Use services to wrap DB calls and validation.', 'DDD-lite'),
('backend', 'master', 'Resilience & Recovery', 'Health checks, graceful degradation, and circuit breakers.', 'Detect DB outage and fall back to cached data.', 'Reliability'),
('backend', 'master', 'Security Posture', 'Rotate secrets, audit access, and sanitize every boundary.', 'Principle of least privilege, audit tables.', 'Trust but verify');
