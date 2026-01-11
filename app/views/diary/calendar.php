<?php
$title = 'Calendar View';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/navbar.php';
?>

<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="glass rounded-xl p-8 neumorphism">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Diary Calendar</h1>
            <div class="flex space-x-4">
                <a href="?month=<?php echo $month; ?>&year=<?php echo $year - 1; ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors calendar-nav">
                    <i class="fas fa-chevron-left"></i> <?php echo $year - 1; ?>
                </a>
                <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-lg font-semibold">
                    <?php echo date('F Y', strtotime("$year-$month-01")); ?>
                </span>
                <a href="?month=<?php echo $month; ?>&year=<?php echo $year + 1; ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors calendar-nav">
                    <?php echo $year + 1; ?> <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-7 gap-2 mb-4">
            <?php
            $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            foreach ($daysOfWeek as $day) {
                echo "<div class='text-center font-semibold text-gray-600 py-2 text-sm'>$day</div>";
            }
            ?>
        </div>

        <div class="grid grid-cols-7 gap-2">
            <?php
            $firstDayOfMonth = strtotime("$year-$month-01");
            $lastDayOfMonth = strtotime(date('Y-m-t', $firstDayOfMonth));
            $startDate = strtotime('last sunday', $firstDayOfMonth);
            $endDate = strtotime('next saturday', $lastDayOfMonth);

            $currentDate = $startDate;
            while ($currentDate <= $endDate) {
                $dateString = date('Y-m-d', $currentDate);
                $dayOfMonth = date('j', $currentDate);
                $isCurrentMonth = date('m', $currentDate) == $month;
                $isToday = $dateString == date('Y-m-d');
                $hasEntry = in_array($dateString, $entryDates);

                $classes = 'h-16 p-2 rounded-lg transition-all hover:scale-105 ';
                if (!$isCurrentMonth) {
                    $classes .= 'text-gray-400 bg-gray-50 ';
                } elseif ($isToday) {
                    $classes .= 'bg-indigo-200 text-indigo-800 font-semibold ';
                } elseif ($hasEntry) {
                    $classes .= 'bg-green-100 text-green-800 hover:bg-green-200 ';
                } else {
                    $classes .= 'bg-white hover:bg-gray-50 neumorphism ';
                }

                echo "<div class='$classes'>";
                if ($isCurrentMonth) {
                    if ($hasEntry) {
                        echo "<a href='" . APP_URL . "/diary/create?date=$dateString' class='block h-full flex flex-col justify-center items-center text-center'>";
                        echo "<span class='text-lg font-semibold'>$dayOfMonth</span>";
                        echo "<i class='fas fa-book text-sm mt-1'></i>";
                        echo "</a>";
                    } else {
                        echo "<a href='" . APP_URL . "/diary/create?date=$dateString' class='block h-full flex flex-col justify-center items-center text-center hover:text-indigo-600'>";
                        echo "<span class='text-lg'>$dayOfMonth</span>";
                        echo "<span class='text-xs mt-1'>Add entry</span>";
                        echo "</a>";
                    }
                } else {
                    echo "<span class='text-lg'>$dayOfMonth</span>";
                }
                echo "</div>";

                $currentDate = strtotime('+1 day', $currentDate);
            }
            ?>
        </div>

        <div class="mt-8 flex justify-center space-x-8 text-sm">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-100 rounded mr-2"></div>
                <span>Has entry</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-indigo-200 rounded mr-2"></div>
                <span>Today</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-white rounded mr-2 neumorphism"></div>
                <span>No entry</span>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>