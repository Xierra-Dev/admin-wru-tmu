<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
/* ===========================
   CSS Kustom untuk Halaman M-Loc History - Based on Schedule Design
   =========================== */

/* Page Layout */
.page-container {
    max-width: 100%;
    margin: 0;
    padding: 10px 15px;
    width: 100%;
    box-sizing: border-box;
}

/* Main search bar (always visible above title) */
.main-search-container {
    position: relative;
    max-width: 600px;
    margin: 0 auto 30px auto;
    text-align: center;
    width: 100%;
}

.main-search-input {
    width: 100%;
    padding: 12px 50px 12px 20px;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    background: white;
    font-size: 14px;
    box-sizing: border-box;
    color: #333;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.main-search-input::placeholder {
    color: #999;
}

.main-search-icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    font-size: 16px;
}

/* Page title (centered above filter buttons) */
.page-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 20px 0;
    text-align: center;
}

/* Filter buttons (positioned to the right) */
.filter-buttons {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-bottom: 30px;
    width: 100%;
}

.filter-btn {
    background: #FFA500; /* Original orange for M-Loc */
    color: white;
    border: 2px solid transparent;
    border-radius: 20px;
    padding: 10px 20px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    min-width: 80px;
    justify-content: center;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    background: #FF8C00;
    color: white;
}

.filter-btn.active {
    border-color: #FF6600;
    box-shadow: 0 0 0 1px #FF6600;
}

/* White background container starting from M-Loc History title */
.content-wrapper {
    background: rgba(255, 255, 255, 0.7);
    border-radius: 15px;
    padding: 25px 40px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(1px);
    width: 100%;
    margin: 0 auto;
    max-width: 100%;
}

/* Main Container */
.mloc-main-container {
    background: white;
    border-radius: 15px;
    padding: 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    width: 100%;
    max-width: none;
    border: 3px solid #007bff; /* Original blue border */
    margin-bottom: 20px;
}

.today-header {
    background: #007bff; /* Original blue */
    color: white;
    padding: 15px 20px;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.mloc-content {
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
    background: white;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

/* Person Cards */
.person-card {
    margin-bottom: 20px;
    border: 2px solid #FFA500; /* Original orange border */
    border-radius: 10px;
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
}

.person-header {
    background: #FFA500; /* Original orange background */
    color: white;
    padding: 12px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.person-name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #000; /* Black color for person name */
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.schedule-count {
    font-size: 0.9rem;
    opacity: 0.9;
    color: #000; /* Black text for better visibility */
}

/* Schedule Container */
.schedules-container {
    padding: 15px;
    background: white;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    width: 100%;
    box-sizing: border-box;
}

/* Schedule Card Wrapper (contains both card and buttons) */
.schedule-card-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

/* Schedule Cards */
.schedule-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 0;
    flex: 1;
    min-width: 280px;
    display: flex;
    align-items: stretch;
    gap: 0;
    position: relative;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    height: 80px;
    overflow: hidden;
}

@media (max-width: 1200px) {
    .schedules-container {
        grid-template-columns: 1fr;
    }
    
    .schedule-card {
        min-width: 250px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .schedules-container {
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
}

.schedule-number {
    background: #007bff; /* Original blue */
    color: white;
    width: 5%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.schedule-content {
    width: 90%;
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    flex: 1;
}

/* When no letter icon is present, expand content area */
.schedule-card-no-icon .schedule-content {
    width: 95%;
}

.schedule-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.schedule-dates {
    text-align: right;
    font-size: 0.8rem;
    color: #000;
    min-width: 120px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.schedule-task-icon {
    background: #FE0000;
    color: white;
    width: 5%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.destination-name {
    font-weight: 600;
    color: #000;
    margin-bottom: 5px;
    font-size: 1rem;
}

.request-info {
    color: #000;
    font-size: 0.85rem;
}

.schedule-dates-info {
    margin-top: 5px;
    color: #000;
    font-size: 0.75rem;
}

.date-info {
    margin-bottom: 3px;
}

.date-info small {
    color: #000;
}

/* History indicator */
.history-indicator {
    color: #dc3545;
    font-size: 0.7rem;
    margin-top: 2px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-today-state {
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

.empty-today-state h5 {
    color: #007bff; /* Blue color */
    font-weight: 500;
}

.empty-today-state p {
    color: #8d9498;
    font-size: 0.95rem;
    margin: 0;
}

.empty-today-state i {
    color: #adb5bd;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-container {
        padding: 10px;
    }
    
    .content-wrapper {
        padding: 20px;
        border-radius: 10px;
        margin: 0;
    }
    
    .main-search-container {
        margin-bottom: 20px;
    }
    
    .page-title {
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .filter-buttons {
        justify-content: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }
    
    .filter-btn {
        min-width: 70px;
        padding: 8px 16px;
        font-size: 13px;
    }
    
    .schedules-container {
        padding: 10px;
        gap: 10px;
    }
    
    .schedule-card {
        min-width: 250px;
        height: 90px;
    }
    
    .schedule-content {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
        padding: 10px;
    }
    
    .schedule-dates {
        text-align: center;
        min-width: auto;
        font-size: 0.7rem;
    }
    
    .schedule-number {
        font-size: 1rem;
    }
    
    .schedule-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
    }
    
    .destination-name,
    .request-info {
        white-space: normal;
        font-size: 0.8rem;
    }
}
</style>

<div class="page-container">
    <!-- Main search bar (outside content wrapper) -->
    <div class="main-search-container">
        <input type="text" class="main-search-input" id="mainSearchInput" placeholder="Search by person name, destination, or requester...">
        <i class="bi bi-search main-search-icon"></i>
    </div>
    
    <div class="content-wrapper">
        <!-- Page title -->
        <div class="page-title"><?= $title ?></div>

        <!-- Filter buttons -->
        <div class="filter-buttons">
            <div class="dropdown">
                <button class="filter-btn" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                    A - Z <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-sort="asc">A - Z</a></li>
                    <li><a class="dropdown-item" href="#" data-sort="desc">Z - A</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="filter-btn" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                    All <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-filter="week">Last week</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="month">Last month</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="3month">Last 3 months</a></li>
                    <li><a class="dropdown-item" href="#" data-filter="all">All History</a></li>
                </ul>
            </div>
        </div>
        <?php if (empty($groupedMlocs)): ?>
            <div class="empty-state">
                <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                <h5 class="text-muted mt-3">No M-Loc History</h5>
                <p class="text-muted">No completed M-Loc records found.</p>
            </div>
        <?php else: ?>
            <?php 
            // Group data by return date for History display
            $dateGroups = [];
            $today = date('Y-m-d');
            
            foreach ($groupedMlocs as $peopleName => $mlocs) {
                foreach ($mlocs as $mloc) {
                    $returnDate = date('Y-m-d', strtotime($mloc['return_date']));
                    $dateKey = $returnDate;
                    
                    if (!isset($dateGroups[$dateKey])) {
                        $dateGroups[$dateKey] = [];
                    }
                    if (!isset($dateGroups[$dateKey][$peopleName])) {
                        $dateGroups[$dateKey][$peopleName] = [];
                    }
                    $dateGroups[$dateKey][$peopleName][] = $mloc;
                }
            }
            
            // Sort date groups by date (newest first for history)
            krsort($dateGroups);
            ?>
            
            <?php foreach ($dateGroups as $dateKey => $dateGroupData): ?>
                <div class="mloc-main-container">
                    <div class="today-header">
                        <?php 
                        $displayDate = new DateTime($dateKey);
                        echo $displayDate->format('d M Y') . ' (Completed)';
                        ?>
                    </div>
                    <div class="mloc-content" id="mlocContainer">
                        <?php foreach ($dateGroupData as $peopleName => $mlocs): ?>
                        <div class="person-card" data-person="<?= esc($peopleName) ?>">
                            <div class="person-header">
                                <span class="person-name"><?= esc($peopleName) ?></span>
                                <div class="header-right">
                                    <span class="schedule-count">(<?= count($mlocs) ?> History Record<?= count($mlocs) > 1 ? 's' : '' ?>)</span>
                                </div>
                            </div>
                            <div class="schedules-container">
                                <?php foreach ($mlocs as $index => $mloc): ?>
                                    <div class="schedule-card-wrapper" style="position: relative; display: flex; align-items: center; margin-bottom: 15px;">
                                        <div class="schedule-card <?= (!isset($mloc['letter']) || $mloc['letter'] != 1) ? 'schedule-card-no-icon' : '' ?>" data-id="<?= isset($mloc['original_id']) ? $mloc['original_id'] : $mloc['id'] ?>" data-date="<?= $mloc['leave_date'] ?>" data-return-date="<?= $mloc['return_date'] ?>">
                                            <div class="schedule-number"><?= $index + 1 ?></div>
                                            <div class="schedule-content">
                                                <div class="schedule-info">
                                                    <div class="destination-name"><?= esc($mloc['destination_name']) ?></div>
                                                    <div class="request-info"><?= esc($mloc['request_by'] ?? 'N/A') ?></div>
                                                </div>
                                                <div class="schedule-dates">
                                                    <?php
                                                    $leaveDate = new DateTime($mloc['leave_date']);
                                                    $returnDate = new DateTime($mloc['return_date']);
                                                    ?>
                                                    <div class="date-info">
                                                        <small><strong>From:</strong> <?= $leaveDate->format('M j, Y') ?></small>
                                                    </div>
                                                    <div class="date-info">
                                                        <small><strong>Until:</strong> <?= $returnDate->format('M j, Y') ?></small>
                                                    </div>
                                                    <div class="history-indicator">
                                                        <i class="bi bi-clock-history"></i> Completed
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Letter icon (only show when letter status is active) -->
                                            <?php if (isset($mloc['letter']) && $mloc['letter'] == 1): ?>
                                                <div class="schedule-task-icon">
                                                    <i class="bi bi-file-earmark-text"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const mainSearchInput = document.getElementById('mainSearchInput');
    
    function performSearch(query) {
        const dateContainers = document.querySelectorAll('.mloc-main-container');
        query = query.toLowerCase();
        
        dateContainers.forEach(container => {
            const personCards = container.querySelectorAll('.person-card');
            let hasVisibleInContainer = false;
            
            personCards.forEach(card => {
                const personName = card.dataset.person.toLowerCase();
                const scheduleCards = card.querySelectorAll('.schedule-card');
                let hasMatch = false;
                
                scheduleCards.forEach(schedule => {
                    const destination = schedule.querySelector('.destination-name').textContent.toLowerCase();
                    const request = schedule.querySelector('.request-info').textContent.toLowerCase();
                    
                    if (personName.includes(query) || destination.includes(query) || request.includes(query)) {
                        schedule.style.display = 'flex';
                        hasMatch = true;
                    } else {
                        schedule.style.display = 'none';
                    }
                });
                
                card.style.display = hasMatch || query === '' ? 'block' : 'none';
                if (hasMatch || query === '') hasVisibleInContainer = true;
            });
            
            container.style.display = hasVisibleInContainer ? 'block' : 'none';
        });
    }
    
    if (mainSearchInput) {
        mainSearchInput.addEventListener('input', function() {
            performSearch(this.value);
        });
    }
    
    // Sort functionality
    document.querySelectorAll('[data-sort]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const sortType = this.dataset.sort;
            const sortText = this.textContent;
            
            // Update button text
            const sortButton = document.getElementById('sortDropdown');
            sortButton.innerHTML = sortText + ' <i class="bi bi-chevron-down"></i>';
            
            const containers = document.querySelectorAll('.mloc-main-container');
            containers.forEach(container => {
                const mlocContent = container.querySelector('.mloc-content');
                const cards = Array.from(mlocContent.querySelectorAll('.person-card'));
                
                cards.sort((a, b) => {
                    const nameA = a.dataset.person.toLowerCase();
                    const nameB = b.dataset.person.toLowerCase();
                    return sortType === 'asc' ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
                });
                
                cards.forEach(card => mlocContent.appendChild(card));
            });
        });
    });
    
    // Filter functionality
    document.querySelectorAll('[data-filter]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filterType = this.dataset.filter;
            const filterText = this.textContent;
            const today = new Date();
            
            // Update button text
            const filterButton = document.getElementById('filterDropdown');
            filterButton.innerHTML = filterText + ' <i class="bi bi-chevron-down"></i>';
            
            const dateContainers = document.querySelectorAll('.mloc-main-container');
            
            dateContainers.forEach(container => {
                const personCards = container.querySelectorAll('.person-card');
                let hasVisibleContent = false;
                
                personCards.forEach(card => {
                    const schedules = card.querySelectorAll('.schedule-card');
                    let hasVisibleSchedule = false;
                    
                    schedules.forEach(schedule => {
                        const returnDate = new Date(schedule.dataset.returnDate);
                        let show = true;
                        
                        switch(filterType) {
                            case 'week':
                                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                                show = returnDate >= weekAgo && returnDate < today;
                                break;
                            case 'month':
                                const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                                show = returnDate >= monthAgo && returnDate < today;
                                break;
                            case '3month':
                                const threeMonthAgo = new Date(today.getTime() - 90 * 24 * 60 * 60 * 1000);
                                show = returnDate >= threeMonthAgo && returnDate < today;
                                break;
                            case 'all':
                            default:
                                show = returnDate < today; // Only show past schedules
                        }
                        
                        schedule.style.display = show ? 'flex' : 'none';
                        if (show) hasVisibleSchedule = true;
                    });
                    
                    card.style.display = hasVisibleSchedule ? 'block' : 'none';
                    if (hasVisibleSchedule) hasVisibleContent = true;
                });
                
                container.style.display = hasVisibleContent ? 'block' : 'none';
            });
        });
    });
});
</script>

<?= $this->endSection() ?>