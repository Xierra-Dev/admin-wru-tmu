<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
.hero-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 0 20px;
}

.hero-content {
    display: flex;
    flex-direction: column;
}

.hero-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.hero-subtitle {
    font-size: 1rem;
    color: #7f8c8d;
    margin-top: 5px;
}

.config-header {
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
}

.date-display {
    font-size: 0.9rem;
    color: #7f8c8d;
    white-space: nowrap;
}

.filter-buttons {
    display: flex;
    gap: 10px;
}

.filter-btn {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #495057;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 6px;
    min-width: 80px;
    justify-content: center;
}

.filter-btn:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.filter-btn.active {
    background: #007bff;
    border-color: #007bff;
    color: white;
}

/* Container for all date sections */
.date-containers {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 0 20px;
}

/* Date container (Today, Yesterday, etc.) */
.date-container {
    border: 1px solid #dee2e6;
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Date headers (Today, Yesterday, etc.) */
.date-header {
    background: <?= ($type === 'vtrip') ? '#007bff' : '#007bff' ?>;
    color: white;
    padding: 15px 20px;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.history-content {
    padding: 20px;
    width: 100%;
    box-sizing: border-box;
    background: white;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

/* Person/Vehicle Cards */
.person-card {
    margin-bottom: 20px;
    border: 2px solid #6c757d; /* Gray color for history */
    border-radius: 10px;
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
}

.person-header {
    background: #6c757d; /* Gray background for history */
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
    color: #fff;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.schedule-count {
    font-size: 0.9rem;
    opacity: 0.9;
    color: #fff;
}

.schedules-container {
    padding: 15px;
    background: white;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    width: 100%;
    box-sizing: border-box;
}

.schedule-card-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}

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
    opacity: 0.8; /* Slightly faded to indicate past records */
}

.schedule-number {
    background: #6c757d; /* Gray for history */
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
    width: 95%;
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    background: white;
    flex: 1;
}

.schedule-info {
    flex: 1;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
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

.destination-name {
    font-weight: 600;
    color: #000;
    margin-bottom: 0;
    font-size: 1rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.request-info {
    color: #000;
    font-size: 0.85rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    position: relative;
}

.request-info::before {
    content: '|';
    color: #999;
    margin-right: 8px;
    font-weight: normal;
}

.schedule-dates-info {
    margin-top: 5px;
    color: #000;
    font-size: 0.75rem;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #7f8c8d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    font-weight: 600;
}

.empty-state p {
    font-size: 1rem;
    margin: 0;
}

/* Responsive */
@media (max-width: 1200px) {
    .schedules-container {
        grid-template-columns: 1fr;
    }
    
    .schedule-card {
        min-width: 250px;
    }
}

@media (max-width: 768px) {
    .hero-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        padding: 0 15px;
    }
    
    .config-header {
        width: 100%;
        justify-content: space-between;
        position: static;
        transform: none;
    }
    
    .filter-buttons {
        flex-wrap: wrap;
    }
    
    .date-containers {
        padding: 0 15px;
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
    
    .request-info::before {
        display: none;
    }
}
</style>

<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title"><?= $title ?></h1>
        <p class="hero-subtitle">Past records that have already completed</p>
    </div>
    
    <div class="config-header">
        <div class="date-display">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
        
        <div class="filter-buttons">
            <div class="dropdown">
                <button class="filter-btn" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                    Latest <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-sort="desc">Latest</a></li>
                    <li><a class="dropdown-item" href="#" data-sort="asc">Oldest</a></li>
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
                    <li><a class="dropdown-item" href="#" data-filter="all">All</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="date-containers">
    <?php if (empty($groupedData)): ?>
        <div class="empty-state">
            <i class="bi bi-clock-history"></i>
            <h3>No History Records</h3>
            <p>No past <?= $type === 'vtrip' ? 'V-Trip' : 'M-Loc' ?> records found.</p>
        </div>
    <?php else: ?>
        <?php 
        $displayedItems = [];
        $itemCounter = 1;
        ?>
        
        <?php foreach ($groupedData as $group): ?>
            <?php if ($group['schedules'] > 0): ?>
                <div class="date-container" data-group="<?= $type ?>">
                    <div class="date-header">
                        History Records
                    </div>
                    <div class="history-content">
                        <div class="person-card">
                            <div class="person-header">
                                <span class="person-name">
                                    <?= $type === 'vtrip' ? esc($group['vehicle']) . ' (' . esc($group['number_plate']) . ')' : esc($group['person']) ?>
                                </span>
                                <div class="header-right">
                                    <span class="schedule-count"><?= $group['schedules'] ?> record<?= $group['schedules'] > 1 ? 's' : '' ?></span>
                                </div>
                            </div>
                            
                            <div class="schedules-container">
                                <?php foreach ($group['schedule_list'] as $schedule): ?>
                                    <?php 
                                    $leaveDate = new DateTime($schedule['leave_date']);
                                    $returnDate = new DateTime($schedule['return_date']);
                                    $today = new DateTime();
                                    
                                    // Only show if return date is in the past
                                    if ($returnDate < $today): 
                                    ?>
                                        <div class="schedule-card-wrapper">
                                            <div class="schedule-card" data-date="<?= $schedule['leave_date'] ?>" data-return-date="<?= $schedule['return_date'] ?>">
                                                <div class="schedule-number"><?= $itemCounter++ ?></div>
                                                <div class="schedule-content">
                                                    <div class="schedule-info">
                                                        <div>
                                                            <div class="destination-name"><?= esc($schedule['destination']) ?></div>
                                                            <div class="request-info">
                                                                <?= $type === 'vtrip' ? esc($schedule['person']) : (isset($schedule['request_by']) ? esc($schedule['request_by']) : 'N/A') ?>
                                                                <?php if ($type === 'mloc' && isset($schedule['letter']) && $schedule['letter']): ?>
                                                                    | Letter: Yes
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-dates">
                                                        <div class="schedule-dates-info">
                                                            <strong><?= $leaveDate->format('M j') ?></strong> - <strong><?= $returnDate->format('M j, Y') ?></strong>
                                                        </div>
                                                        <div style="color: #dc3545; font-size: 0.7rem; margin-top: 2px;">
                                                            <i class="bi bi-clock-history"></i> Completed
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <?php if (empty($displayedItems)): ?>
            <div class="empty-state">
                <i class="bi bi-clock-history"></i>
                <h3>No Completed Records</h3>
                <p>No completed <?= $type === 'vtrip' ? 'V-Trip' : 'M-Loc' ?> records found.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sort functionality
    const sortDropdown = document.getElementById('sortDropdown');
    const sortItems = document.querySelectorAll('#sortDropdown + .dropdown-menu .dropdown-item');
    
    sortItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const sortOrder = this.getAttribute('data-sort');
            const sortText = this.textContent;
            
            // Update button text
            const btnText = sortDropdown.querySelector('span') || sortDropdown;
            const iconHtml = ' <i class="bi bi-chevron-down"></i>';
            sortDropdown.innerHTML = sortText + iconHtml;
            
            // Sort logic
            sortSchedules(sortOrder);
        });
    });
    
    // Filter functionality
    const filterDropdown = document.getElementById('filterDropdown');
    const filterItems = document.querySelectorAll('#filterDropdown + .dropdown-menu .dropdown-item');
    
    filterItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const filterType = this.getAttribute('data-filter');
            const filterText = this.textContent;
            
            // Update button text
            const btnText = filterDropdown.querySelector('span') || filterDropdown;
            const iconHtml = ' <i class="bi bi-chevron-down"></i>';
            filterDropdown.innerHTML = filterText + iconHtml;
            
            // Filter logic
            filterSchedules(filterType);
        });
    });
    
    function sortSchedules(order) {
        const containers = document.querySelectorAll('.date-container');
        
        containers.forEach(container => {
            const schedulesContainer = container.querySelector('.schedules-container');
            const schedules = Array.from(schedulesContainer.querySelectorAll('.schedule-card-wrapper'));
            
            schedules.sort((a, b) => {
                const dateA = new Date(a.querySelector('.schedule-card').getAttribute('data-date'));
                const dateB = new Date(b.querySelector('.schedule-card').getAttribute('data-date'));
                
                return order === 'asc' ? dateA - dateB : dateB - dateA;
            });
            
            // Clear and re-append
            schedulesContainer.innerHTML = '';
            schedules.forEach(schedule => {
                schedulesContainer.appendChild(schedule);
            });
            
            // Update numbering
            updateScheduleNumbers();
        });
    }
    
    function filterSchedules(filterType) {
        const today = new Date();
        const containers = document.querySelectorAll('.date-container');
        
        containers.forEach(container => {
            const schedulesContainer = container.querySelector('.schedules-container');
            const schedules = schedulesContainer.querySelectorAll('.schedule-card-wrapper');
            let hasVisibleSchedule = false;
            
            schedules.forEach(scheduleWrapper => {
                const schedule = scheduleWrapper.querySelector('.schedule-card');
                const returnDate = new Date(schedule.getAttribute('data-return-date'));
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
                
                scheduleWrapper.style.display = show ? 'flex' : 'none';
                if (show) hasVisibleSchedule = true;
            });
            
            container.style.display = hasVisibleSchedule ? 'block' : 'none';
        });
        
        // Update numbering after filtering
        updateScheduleNumbers();
    }
    
    function updateScheduleNumbers() {
        let counter = 1;
        const visibleSchedules = document.querySelectorAll('.schedule-card-wrapper[style*="flex"], .schedule-card-wrapper:not([style]), .schedule-card-wrapper[style=""]');
        
        visibleSchedules.forEach(wrapper => {
            const numberElement = wrapper.querySelector('.schedule-number');
            if (numberElement) {
                numberElement.textContent = counter++;
            }
        });
    }
});
</script>

<?= $this->endSection() ?>