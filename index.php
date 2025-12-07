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
