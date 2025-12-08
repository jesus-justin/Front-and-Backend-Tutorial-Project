<?php
require __DIR__ . '/db.php';
$fallbackData = require __DIR__ . '/data/sample_data.php';

$stages = [
    'basic' => 'Basic',
    'intermediate' => 'Intermediate',
    'advanced' => 'Advanced',
    'master' => 'Master',
];

$stageDescriptions = [
    'basic' => 'Foundations, terminology, and the smallest possible building blocks to get productive.',
    'intermediate' => 'Patterns that scale beyond a single page: reusable layouts, APIs, and observability basics.',
    'advanced' => 'Performance, reliability, and orchestration so teams can move quickly without breaking things.',
    'master' => 'Systems thinking, resilience, and product-minded engineering that holds up under pressure.',
];

$areas = [
    'frontend' => 'Frontend',
    'backend' => 'Backend',
];

$records = $fallbackData;
$usingFallback = true;
$pdo = createPdo($config);

if ($pdo instanceof PDO) {
    try {
        $stmt = $pdo->query(
            "SELECT area, stage, title, summary, demo, callout FROM exhibits ORDER BY FIELD(stage, 'basic','intermediate','advanced','master'), area, title"
        );
        $rows = $stmt->fetchAll();
        if ($rows) {
            $records = $rows;
            $usingFallback = false;
        }
    } catch (Throwable $e) {
        $records = $fallbackData;
        $usingFallback = true;
    }
}

$grouped = [];
foreach ($areas as $areaKey => $areaLabel) {
    foreach ($stages as $stageKey => $stageLabel) {
        $grouped[$areaKey][$stageKey] = [];
    }
}

foreach ($records as $row) {
    $areaKey = $row['area'] ?? null;
    $stageKey = $row['stage'] ?? null;
    if (isset($grouped[$areaKey][$stageKey])) {
        $grouped[$areaKey][$stageKey][] = $row;
    }
}


$visualByTitle = [
    'semantic layout' => 'visual-layout',
    'styling essentials' => 'visual-styling',
    'dom events' => 'visual-ripple',
    'responsive systems' => 'visual-responsive',
    'fetching json' => 'visual-stream',
    'form ux' => 'visual-forms',
    'performance & media' => 'visual-speed',
    'state & data shapes' => 'visual-state',
    'testing the ui' => 'visual-testing',
    'design systems' => 'visual-design',
    'progressive enhancement' => 'visual-progressive',
    'observability in ui' => 'visual-observe',
];

$visualFallback = [
    'visual-particles',
    'visual-ripple',
    'visual-stream',
    'visual-speed',
    'visual-grid',
    'visual-design',
];
$visualIndex = 0;

function visual_class(array $row, array $byTitle, array $fallback, int &$index): string
{
    $titleKey = strtolower(trim($row['title'] ?? ''));
    if ($titleKey !== '' && isset($byTitle[$titleKey])) {
        return $byTitle[$titleKey];
    }

    $choice = $fallback[$index % count($fallback)];
    $index++;
    return $choice;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fullstack Museum</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header class="hero">
        <div class="hero__content">
            <p class="eyebrow">Book + Museum</p>
            <h1>Frontend and Backend, step by step.</h1>
            <p class="lede">Walk through curated exhibits that show how front and back evolve from basics to mastery. Each card is a habit, a tool, or a mindset upgrade.</p>
            <div class="cta-row">
                <a class="cta" href="#basic">Start at Basic</a>
                <a class="cta ghost" href="./database/dev_museum.sql">Download SQL seed</a>
            </div>
            <?php if ($usingFallback): ?>
                <div class="notice">Database not connected. Showing built-in sample exhibits.</div>
            <?php else: ?>
                <div class="notice success">Live data from MySQL loaded. Enjoy the tour.</div>
            <?php endif; ?>
        </div>
        <div class="hero__meta">
            <div class="meta-card">
                <p class="label">Tracks</p>
                <p class="value">Frontend + Backend</p>
            </div>
            <div class="meta-card">
                <p class="label">Stages</p>
                <p class="value">Basic · Intermediate · Advanced · Master</p>
            </div>
            <div class="meta-card">
                <p class="label">Usage</p>
                <p class="value">Use locally with XAMPP (PHP + MySQL)</p>
            </div>
        </div>
    </header>

    <section class="controls" aria-label="Filters">
        <div class="filter-group">
            <span class="filter-label">Show:</span>
            <button type="button" class="pill active" data-filter="all">All</button>
            <button type="button" class="pill" data-filter="frontend">Frontend only</button>
            <button type="button" class="pill" data-filter="backend">Backend only</button>
        </div>
    </section>

    <main>
        <?php foreach ($stages as $stageKey => $stageLabel): ?>
            <section class="stage" id="<?php echo htmlspecialchars($stageKey); ?>">
                <div class="stage__header">
                    <div>
                        <p class="eyebrow">Stage</p>
                        <h2><?php echo htmlspecialchars($stageLabel); ?></h2>
                        <p class="stage__description"><?php echo htmlspecialchars($stageDescriptions[$stageKey]); ?></p>
                    </div>
                    <div class="stage__badge">Level: <?php echo htmlspecialchars($stageLabel); ?></div>
                </div>

                <div class="columns">
                    <?php foreach ($areas as $areaKey => $areaLabel): ?>
                        <div class="column area-column" data-area="<?php echo htmlspecialchars($areaKey); ?>">
                            <div class="column__header">
                                <p class="eyebrow"><?php echo htmlspecialchars($areaLabel); ?></p>
                                <p class="muted"><?php echo $areaKey === 'frontend' ? 'UI, UX, and browser craft.' : 'Servers, data, and delivery.'; ?></p>
                            </div>
                            <div class="card-grid">
                                <?php if (empty($grouped[$areaKey][$stageKey])): ?>
                                    <div class="card empty">Coming soon. Add more exhibits via the database.</div>
                                <?php else: ?>
                                    <?php foreach ($grouped[$areaKey][$stageKey] as $row): ?>
                                        <article class="card" tabindex="0">
                                            <div class="card__top">
                                                <?php if (!empty($row['callout'])): ?>
                                                    <span class="chip"><?php echo htmlspecialchars($row['callout']); ?></span>
                                                <?php endif; ?>
                                                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                                                <p class="summary"><?php echo htmlspecialchars($row['summary']); ?></p>
                                            </div>
                                            <?php if (!empty($row['demo'])): ?>
                                                <p class="demo"><strong>Demo idea:</strong> <?php echo htmlspecialchars($row['demo']); ?></p>
                                            <?php endif; ?>
                                            <?php if (($row['area'] ?? '') === 'frontend'): ?>
                                                <?php $visualClass = visual_class($row, $visualByTitle, $visualFallback, $visualIndex); ?>
                                                <div class="mini-visual visual-<?php echo htmlspecialchars($row['stage'] ?? 'basic'); ?> <?php echo htmlspecialchars($visualClass); ?>" aria-hidden="true">
                                                    <div class="effect">
                                                        <div class="layer backdrop"></div>
                                                        <div class="layer glow"></div>
                                                        <div class="layer content">
                                                            <div class="ui hero"></div>
                                                            <div class="ui card a"></div>
                                                            <div class="ui card b"></div>
                                                            <div class="ui card c"></div>
                                                        </div>
                                                        <div class="particles">
                                                            <span class="p p1"></span>
                                                            <span class="p p2"></span>
                                                            <span class="p p3"></span>
                                                            <span class="p p4"></span>
                                                        </div>
                                                        <div class="beam"></div>
                                                    </div>
                                                </div>
                                                <details class="code-sample">
                                                    <summary>View code sample</summary>
                                                    <div class="code-instructions">
                                                        <p class="instruction-title">How to implement:</p>
                                                        <ol class="instruction-steps">
                                                            <?php
                                                            $titleLower = strtolower($row['title'] ?? '');
                                                            if ($titleLower === 'semantic layout') {
                                                                echo '<li>Use semantic HTML5 tags like <code>&lt;header&gt;</code>, <code>&lt;nav&gt;</code>, <code>&lt;main&gt;</code>, <code>&lt;footer&gt;</code></li>';
                                                                echo '<li>Add meaningful landmarks for screen readers</li>';
                                                                echo '<li>Keep structure clean before applying styles</li>';
                                                            } elseif ($titleLower === 'styling essentials') {
                                                                echo '<li>Use CSS custom properties for color tokens: <code>--primary</code>, <code>--spacing</code></li>';
                                                                echo '<li>Apply flexbox with <code>display: flex</code> and <code>gap</code> for spacing</li>';
                                                                echo '<li>Use <code>clamp()</code> for responsive sizing</li>';
                                                            } elseif ($titleLower === 'dom events') {
                                                                echo '<li>Attach listeners with <code>element.addEventListener(\'click\', handler)</code></li>';
                                                                echo '<li>Use event delegation on parent containers for dynamic elements</li>';
                                                                echo '<li>Keep handlers small and pure</li>';
                                                            } elseif ($titleLower === 'responsive systems') {
                                                                echo '<li>Use <code>display: grid</code> with <code>grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))</code></li>';
                                                                echo '<li>Apply <code>@media</code> breakpoints for tablet/desktop</li>';
                                                                echo '<li>Use fluid typography with <code>clamp(16px, 2vw, 20px)</code></li>';
                                                            } elseif ($titleLower === 'fetching json') {
                                                                echo '<li>Call APIs with <code>fetch(\'/api/data\')</code> and handle promises</li>';
                                                                echo '<li>Show loading states while fetching</li>';
                                                                echo '<li>Render data dynamically and handle errors gracefully</li>';
                                                            } elseif ($titleLower === 'form ux') {
                                                                echo '<li>Add accessible labels with <code>&lt;label for="..."&gt;</code></li>';
                                                                echo '<li>Validate inline and show errors with <code>aria-live</code></li>';
                                                                echo '<li>Use <code>:invalid</code> and <code>:focus</code> states for visual feedback</li>';
                                                            } elseif ($titleLower === 'performance & media') {
                                                                echo '<li>Lazy-load images with <code>loading="lazy"</code></li>';
                                                                echo '<li>Use <code>IntersectionObserver</code> to trigger animations on scroll</li>';
                                                                echo '<li>Respect <code>prefers-reduced-motion</code> media query</li>';
                                                            } elseif ($titleLower === 'state & data shapes') {
                                                                echo '<li>Normalize data into predictable shapes</li>';
                                                                echo '<li>Derive UI state from a single source of truth</li>';
                                                                echo '<li>Use event buses or state managers to avoid prop-drilling</li>';
                                                            } elseif ($titleLower === 'testing the ui') {
                                                                echo '<li>Write assertions for accessibility with tools like axe</li>';
                                                                echo '<li>Test user flows with Cypress or Playwright</li>';
                                                                echo '<li>Design components to be testable and isolated</li>';
                                                            } elseif ($titleLower === 'design systems') {
                                                                echo '<li>Define design tokens (colors, spacing, fonts) in CSS variables</li>';
                                                                echo '<li>Build composable components with variants</li>';
                                                                echo '<li>Document usage patterns in a style guide</li>';
                                                            } elseif ($titleLower === 'progressive enhancement') {
                                                                echo '<li>Ship core HTML first, ensure it works without JS</li>';
                                                                echo '<li>Layer JavaScript enhancements progressively</li>';
                                                                echo '<li>Add offline support with service workers</li>';
                                                            } elseif ($titleLower === 'observability in ui') {
                                                                echo '<li>Track user journeys with analytics events</li>';
                                                                echo '<li>Use feature flags to experiment safely</li>';
                                                                echo '<li>Instrument UI interactions for product insights</li>';
                                                            } else {
                                                                echo '<li>Follow best practices for clean, maintainable code</li>';
                                                                echo '<li>Keep components small and focused</li>';
                                                                echo '<li>Test and iterate based on user feedback</li>';
                                                            }
                                                            ?>
                                                        </ol>
                                                    </div>
                                                    <pre class="code-block"><code><?php
$titleLower = strtolower($row['title'] ?? '');
if ($titleLower === 'semantic layout') {
    echo htmlspecialchars('<header>
  <nav>
    <a href="#home">Home</a>
    <a href="#about">About</a>
  </nav>
</header>
<main>
  <section>
    <h1>Welcome</h1>
    <p>Use semantic tags for structure.</p>
  </section>
</main>
<footer>
  <p>&copy; 2025 Your Site</p>
</footer>');
} elseif ($titleLower === 'styling essentials') {
    echo htmlspecialchars(':root {
  --primary: #a855f7;
  --spacing: 1rem;
}

.card {
  display: flex;
  gap: var(--spacing);
  padding: var(--spacing);
  background: var(--primary);
  border-radius: 8px;
}');
} elseif ($titleLower === 'dom events') {
    echo htmlspecialchars('const button = document.querySelector(\'.btn\');
button.addEventListener(\'click\', (e) => {
  e.target.classList.toggle(\'active\');
});

// Event delegation
document.querySelector(\'.cards\').addEventListener(\'click\', (e) => {
  if (e.target.matches(\'.card\')) {
    e.target.classList.toggle(\'highlight\');
  }
});');
} elseif ($titleLower === 'responsive systems') {
    echo htmlspecialchars('.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1rem;
}

h1 {
  font-size: clamp(1.5rem, 4vw, 3rem);
}

@media (min-width: 768px) {
  .grid {
    gap: 2rem;
  }
}');
} elseif ($titleLower === 'fetching json') {
    echo htmlspecialchars('async function fetchData() {
  const response = await fetch(\'/api/exhibits\');
  const data = await response.json();
  
  data.forEach(item => {
    const card = document.createElement(\'div\');
    card.textContent = item.title;
    document.querySelector(\'.container\').append(card);
  });
}

fetchData().catch(err => console.error(err));');
} elseif ($titleLower === 'form ux') {
    echo htmlspecialchars('<form>
  <label for="email">Email</label>
  <input type="email" id="email" required>
  <span class="error" aria-live="polite"></span>
  <button type="submit">Submit</button>
</form>

<style>
input:invalid {
  border-color: red;
}
input:focus {
  outline: 2px solid blue;
}
</style>');
} elseif ($titleLower === 'performance & media') {
    echo htmlspecialchars('<img src="hero.jpg" loading="lazy" alt="Hero image">

<script>
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add(\'visible\');
    }
  });
});

document.querySelectorAll(\'.card\').forEach(card => {
  observer.observe(card);
});
</script>');
} elseif ($titleLower === 'state & data shapes') {
    echo htmlspecialchars('const state = {
  items: [],
  filter: \'all\'
};

function updateUI() {
  const filtered = state.items.filter(item => 
    state.filter === \'all\' || item.type === state.filter
  );
  render(filtered);
}

state.items = fetchItems();
updateUI();');
} elseif ($titleLower === 'testing the ui') {
    echo htmlspecialchars('// Cypress test example
describe(\'Exhibit filters\', () => {
  it(\'should filter by frontend\', () => {
    cy.visit(\'/\');
    cy.get(\'[data-filter="frontend"]\').click();
    cy.get(\'.card\').should(\'have.length.greaterThan\', 0);
  });
});');
} elseif ($titleLower === 'design systems') {
    echo htmlspecialchars(':root {
  --color-primary: #a855f7;
  --color-secondary: #22d3ee;
  --space-sm: 0.5rem;
  --space-md: 1rem;
  --radius: 12px;
}

.btn {
  padding: var(--space-md);
  background: var(--color-primary);
  border-radius: var(--radius);
}');
} elseif ($titleLower === 'progressive enhancement') {
    echo htmlspecialchars('<!-- Core HTML works without JS -->
<a href="/exhibits?stage=basic">Basic</a>

<script>
// Enhance with JS
document.querySelectorAll(\'a\').forEach(link => {
  link.addEventListener(\'click\', (e) => {
    e.preventDefault();
    fetch(link.href).then(/* SPA navigation */);
  });
});
</script>');
} elseif ($titleLower === 'observability in ui') {
    echo htmlspecialchars('function trackEvent(name, data) {
  fetch(\'/api/analytics\', {
    method: \'POST\',
    body: JSON.stringify({ event: name, ...data })
  });
}

document.querySelector(\'.filter\').addEventListener(\'click\', (e) => {
  trackEvent(\'filter_click\', { filter: e.target.dataset.filter });
});');
} else {
    echo htmlspecialchars('// Sample code for ' . ($row['title'] ?? 'this exhibit') . '
// Follow best practices and keep code clean

const example = () => {
  console.log(\'Implement your feature here\');
};');
}
                                                    ?></code></pre>
                                                </details>
                                            <?php endif; ?>
                                            <?php if (($row['area'] ?? '') === 'backend'): ?>
                                                <details class="code-sample">
                                                    <summary>View code sample</summary>
                                                    <div class="code-instructions">
                                                        <p class="instruction-title">How to implement:</p>
                                                        <ol class="instruction-steps">
                                                            <?php
                                                            $titleLower = strtolower($row['title'] ?? '');
                                                            if ($titleLower === 'http & routing') {
                                                                echo '<li>Define routes that map URLs to handlers</li>';
                                                                echo '<li>Set proper HTTP headers like <code>Content-Type</code></li>';
                                                                echo '<li>Return JSON with <code>json_encode()</code> or render HTML</li>';
                                                            } elseif ($titleLower === 'database reads') {
                                                                echo '<li>Use PDO with prepared statements for safety</li>';
                                                                echo '<li>Always parameterize queries to prevent SQL injection</li>';
                                                                echo '<li>Set charset to <code>utf8mb4</code> for full Unicode support</li>';
                                                            } elseif ($titleLower === 'input validation') {
                                                                echo '<li>Validate all incoming data with <code>filter_input()</code></li>';
                                                                echo '<li>Normalize values (trim, lowercase) before processing</li>';
                                                                echo '<li>Return early on validation errors with clear messages</li>';
                                                            } elseif ($titleLower === 'rest patterns') {
                                                                echo '<li>Use predictable URLs like <code>/api/resource/:id</code></li>';
                                                                echo '<li>Match HTTP verbs to actions (GET/POST/PUT/DELETE)</li>';
                                                                echo '<li>Return proper status codes (200, 201, 404, 500)</li>';
                                                            } elseif ($titleLower === 'sessions & auth') {
                                                                echo '<li>Hash passwords with <code>password_hash()</code></li>';
                                                                echo '<li>Use sessions to track authenticated users</li>';
                                                                echo '<li>Add CSRF tokens to protect forms</li>';
                                                            } elseif ($titleLower === 'logging & metrics') {
                                                                echo '<li>Log requests with path, duration, and status code</li>';
                                                                echo '<li>Use structured logs (JSON) for easier parsing</li>';
                                                                echo '<li>Add correlation IDs to trace requests across systems</li>';
                                                            } elseif ($titleLower === 'caching & pagination') {
                                                                echo '<li>Paginate queries with <code>LIMIT</code> and <code>OFFSET</code></li>';
                                                                echo '<li>Cache frequent queries in memory or Redis</li>';
                                                                echo '<li>Expose pagination metadata via <code>Link</code> headers</li>';
                                                            } elseif ($titleLower === 'background work') {
                                                                echo '<li>Queue tasks with a job system (Redis, RabbitMQ)</li>';
                                                                echo '<li>Retry failed jobs with exponential backoff</li>';
                                                                echo '<li>Keep jobs idempotent to handle retries safely</li>';
                                                            } elseif ($titleLower === 'file handling') {
                                                                echo '<li>Validate file type and size before accepting uploads</li>';
                                                                echo '<li>Sanitize filenames and store in a secure directory</li>';
                                                                echo '<li>Generate checksums (SHA-256) and store metadata</li>';
                                                            } elseif ($titleLower === 'domain design') {
                                                                echo '<li>Model entities as aggregates with clear boundaries</li>';
                                                                echo '<li>Enforce business rules and invariants in services</li>';
                                                                echo '<li>Keep use-cases explicit and testable</li>';
                                                            } elseif ($titleLower === 'resilience & recovery') {
                                                                echo '<li>Add health check endpoints for monitoring</li>';
                                                                echo '<li>Implement circuit breakers to prevent cascading failures</li>';
                                                                echo '<li>Degrade gracefully when dependencies are down</li>';
                                                            } elseif ($titleLower === 'security posture') {
                                                                echo '<li>Rotate secrets regularly and use environment variables</li>';
                                                                echo '<li>Apply principle of least privilege to database users</li>';
                                                                echo '<li>Audit access logs and sanitize all input/output</li>';
                                                            } else {
                                                                echo '<li>Follow best practices for secure, maintainable backend code</li>';
                                                                echo '<li>Keep functions small and focused</li>';
                                                                echo '<li>Write tests and monitor in production</li>';
                                                            }
                                                            ?>
                                                        </ol>
                                                    </div>
                                                    <pre class="code-block"><code><?php
$titleLower = strtolower($row['title'] ?? '');
if ($titleLower === 'http & routing') {
    echo htmlspecialchars('<?php
// Simple router
$path = parse_url($_SERVER[\'REQUEST_URI\'], PHP_URL_PATH);

if ($path === \'/api/exhibits\') {
    header(\'Content-Type: application/json\');
    echo json_encode([\'status\' => \'ok\', \'data\' => $exhibits]);
} elseif ($path === \'/\') {
    include \'index.php\';
} else {
    http_response_code(404);
    echo \'Not Found\';
}');
} elseif ($titleLower === 'database reads') {
    echo htmlspecialchars('<?php
$pdo = new PDO(\'mysql:host=localhost;dbname=dev_museum;charset=utf8mb4\', \'root\', \'\');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare(\'SELECT * FROM exhibits WHERE stage = :stage\');
$stmt->execute([\'stage\' => $_GET[\'stage\'] ?? \'basic\']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);');
} elseif ($titleLower === 'input validation') {
    echo htmlspecialchars('<?php
$stage = filter_input(INPUT_GET, \'stage\', FILTER_SANITIZE_STRING);
$stage = strtolower(trim($stage ?? \'basic\'));

if (!in_array($stage, [\'basic\', \'intermediate\', \'advanced\', \'master\'])) {
    http_response_code(400);
    echo json_encode([\'error\' => \'Invalid stage parameter\']);
    exit;
}

// Proceed with valid input
$stmt = $pdo->prepare(\'SELECT * FROM exhibits WHERE stage = :stage\');
$stmt->execute([\'stage\' => $stage]);');
} elseif ($titleLower === 'rest patterns') {
    echo htmlspecialchars('<?php
// GET /api/exhibits
if ($_SERVER[\'REQUEST_METHOD\'] === \'GET\' && $path === \'/api/exhibits\') {
    $stage = $_GET[\'stage\'] ?? null;
    $stmt = $pdo->prepare(\'SELECT * FROM exhibits WHERE (:stage IS NULL OR stage = :stage)\');
    $stmt->execute([\'stage\' => $stage]);
    
    http_response_code(200);
    header(\'Content-Type: application/json\');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// POST /api/exhibits
if ($_SERVER[\'REQUEST_METHOD\'] === \'POST\' && $path === \'/api/exhibits\') {
    $data = json_decode(file_get_contents(\'php://input\'), true);
    // Validate and insert...
    http_response_code(201);
    echo json_encode([\'id\' => $newId]);
}');
} elseif ($titleLower === 'sessions & auth') {
    echo htmlspecialchars('<?php
session_start();

// Login
if ($_POST[\'action\'] === \'login\') {
    $user = findUserByEmail($_POST[\'email\']);
    if ($user && password_verify($_POST[\'password\'], $user[\'password_hash\'])) {
        $_SESSION[\'user_id\'] = $user[\'id\'];
        $_SESSION[\'csrf_token\'] = bin2hex(random_bytes(32));
        header(\'Location: /dashboard\');
    } else {
        echo \'Invalid credentials\';
    }
}

// Protected route
if (!isset($_SESSION[\'user_id\'])) {
    http_response_code(401);
    echo \'Unauthorized\';
    exit;
}');
} elseif ($titleLower === 'logging & metrics') {
    echo htmlspecialchars('<?php
function logRequest($path, $duration, $status) {
    $log = [
        \'timestamp\' => date(\'c\'),
        \'path\' => $path,
        \'duration_ms\' => round($duration * 1000, 2),
        \'status\' => $status,
        \'correlation_id\' => $_SERVER[\'HTTP_X_CORRELATION_ID\'] ?? uniqid()
    ];
    file_put_contents(\'logs/requests.log\', json_encode($log) . PHP_EOL, FILE_APPEND);
}

$start = microtime(true);
// Handle request...
$duration = microtime(true) - $start;
logRequest($_SERVER[\'REQUEST_URI\'], $duration, http_response_code());');
} elseif ($titleLower === 'caching & pagination') {
    echo htmlspecialchars('<?php
// Pagination
$page = max(1, (int)($_GET[\'page\'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare(\'SELECT * FROM exhibits LIMIT :limit OFFSET :offset\');
$stmt->bindValue(\':limit\', $perPage, PDO::PARAM_INT);
$stmt->bindValue(\':offset\', $offset, PDO::PARAM_INT);
$stmt->execute();

// Simple cache
$cacheKey = \'exhibits_page_\' . $page;
$cached = apcu_fetch($cacheKey);
if ($cached === false) {
    $cached = $stmt->fetchAll(PDO::FETCH_ASSOC);
    apcu_store($cacheKey, $cached, 30); // 30 seconds
}
echo json_encode($cached);');
} elseif ($titleLower === 'background work') {
    echo htmlspecialchars('<?php
// Queue a job
function queueJob($type, $data) {
    $job = [
        \'id\' => uniqid(),
        \'type\' => $type,
        \'data\' => $data,
        \'attempts\' => 0,
        \'created_at\' => time()
    ];
    // Push to Redis queue
    $redis = new Redis();
    $redis->connect(\'127.0.0.1\', 6379);
    $redis->rPush(\'job_queue\', json_encode($job));
}

// Worker
while (true) {
    $job = json_decode($redis->blPop(\'job_queue\', 5)[1] ?? \'{}\', true);
    if ($job) {
        try {
            processJob($job);
        } catch (Exception $e) {
            retryJob($job);
        }
    }
}');
} elseif ($titleLower === 'file handling') {
    echo htmlspecialchars('<?php
if ($_FILES[\'file\'][\'error\'] === UPLOAD_ERR_OK) {
    $tmpPath = $_FILES[\'file\'][\'tmp_name\'];
    $size = $_FILES[\'file\'][\'size\'];
    $mime = mime_content_type($tmpPath);
    
    // Validate
    if (!in_array($mime, [\'image/jpeg\', \'image/png\'])) {
        die(\'Invalid file type\');
    }
    if ($size > 5 * 1024 * 1024) {
        die(\'File too large\');
    }
    
    // Sanitize and store
    $filename = bin2hex(random_bytes(16)) . \'.jpg\';
    $checksum = hash_file(\'sha256\', $tmpPath);
    move_uploaded_file($tmpPath, \'uploads/\' . $filename);
    
    // Store metadata in DB
    $pdo->prepare(\'INSERT INTO files (filename, checksum, size) VALUES (?, ?, ?)\')
        ->execute([$filename, $checksum, $size]);
}');
} elseif ($titleLower === 'domain design') {
    echo htmlspecialchars('<?php
class ExhibitService {
    private $pdo;
    
    public function createExhibit(array $data): int {
        // Enforce invariants
        if (empty($data[\'title\']) || empty($data[\'stage\'])) {
            throw new InvalidArgumentException(\'Title and stage required\');
        }
        
        $stmt = $this->pdo->prepare(
            \'INSERT INTO exhibits (area, stage, title, summary) VALUES (:area, :stage, :title, :summary)\'
        );
        $stmt->execute($data);
        return (int)$this->pdo->lastInsertId();
    }
    
    public function getExhibitsByStage(string $stage): array {
        $stmt = $this->pdo->prepare(\'SELECT * FROM exhibits WHERE stage = :stage\');
        $stmt->execute([\'stage\' => $stage]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}');
} elseif ($titleLower === 'resilience & recovery') {
    echo htmlspecialchars('<?php
// Health check endpoint
if ($path === \'/health\') {
    $checks = [
        \'database\' => checkDatabase(),
        \'cache\' => checkCache(),
        \'disk\' => disk_free_space(\'.\') > 1024 * 1024 * 100
    ];
    
    $healthy = !in_array(false, $checks, true);
    http_response_code($healthy ? 200 : 503);
    echo json_encode([\'status\' => $healthy ? \'ok\' : \'degraded\', \'checks\' => $checks]);
}

function checkDatabase() {
    try {
        $pdo->query(\'SELECT 1\');
        return true;
    } catch (Exception $e) {
        return false;
    }
}');
} elseif ($titleLower === 'security posture') {
    echo htmlspecialchars('<?php
// Load secrets from env
$dbPassword = getenv(\'DB_PASSWORD\');
$apiKey = getenv(\'API_KEY\');

// Least privilege DB user
$pdo = new PDO(\'mysql:host=localhost;dbname=dev_museum\', \'app_readonly\', $dbPassword);

// Sanitize output
function sanitize($data) {
    if (is_array($data)) {
        return array_map(\'sanitize\', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, \'UTF-8\');
}

// Audit log
function auditAction($user_id, $action, $resource) {
    file_put_contents(\'logs/audit.log\', json_encode([
        \'timestamp\' => date(\'c\'),
        \'user_id\' => $user_id,
        \'action\' => $action,
        \'resource\' => $resource
    ]) . PHP_EOL, FILE_APPEND);
}');
} else {
    echo htmlspecialchars('<?php
// Sample backend code for ' . ($row['title'] ?? 'this exhibit') . '
// Follow best practices for security and performance

function example() {
    // Implement your backend logic here
    return [\'status\' => \'ok\'];
}');
}
                                                    ?></code></pre>
                                                </details>
                                            <?php endif; ?>
                                            <footer class="card__footer">
                                                <span class="pill pill-ghost"><?php echo htmlspecialchars(ucfirst($row['area'])); ?></span>
                                                <span class="pill pill-ghost"><?php echo htmlspecialchars(ucfirst($row['stage'])); ?></span>
                                            </footer>
                                        </article>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>
    </main>

    <footer class="footer">
        <p>Ready to publish? Import the SQL, adjust <code>.env</code>, then push to GitHub. The museum is yours.</p>
    </footer>

    <script src="./assets/js/app.js"></script>
</body>
</html>
