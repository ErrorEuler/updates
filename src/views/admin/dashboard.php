<?php
ob_start();
?>

<style>
    .dashboard {
        min-height: 100vh;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .card {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-0.25rem);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes scaleUp {
        from { transform: scale(0.95); }
        to { transform: scale(1); }
    }
    .animate-scaleUp {
        animation: scaleUp 0.3s ease-out forwards;
    }

    .table-container {
        min-height: 400px;
        overflow-x: auto;
    }

    .schedule-table {
        font-size: 0.875rem;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .schedule-table th {
        background: #1a202c;
        color: #ffffff;
        font-weight: 600;
        border-bottom: 2px solid #2d3748;
    }
    .schedule-table td {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.3s ease;
    }
    .schedule-table tr:hover td {
        background: #edf2f7;
    }

    .activity-logs-container {
        max-height: 600px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #1a202c #f3f4f6;
    }
    .activity-logs-container::-webkit-scrollbar {
        width: 0.5rem;
    }
    .activity-logs-container::-webkit-scrollbar-track {
        background: #f3f4f6;
    }
    .activity-logs-container::-webkit-scrollbar-thumb {
        background: #1a202c;
        border-radius: 0.25rem;
    }

    .user-avatar {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, #1a202c, #4a5568);
        color: #ffffff;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .premium-button {
        background-color: #f59e0b;
        color: #ffffff;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .premium-button:hover {
        background-color: #d97706;
        transform: translateY(-2px);
    }
    .premium-button svg {
        stroke: #ffffff;
        margin-right: 0.5rem;
    }

    .stat-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: #f59e0b;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-icon svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke: #ffffff;
    }

    @media (max-width: 768px) {
        .schedule-table {
            font-size: 0.75rem;
        }
        .schedule-table th,
        .schedule-table td {
            padding: 0.5rem 0.5rem;
        }
        .card {
            margin-bottom: 1rem;
        }
    }
</style>

<div class="dashboard">
    <div class="max-w-7xl mx-auto py-6">
        <!-- Premium Display Logo -->
        <div class="mb-6 flex items-center justify-center">
            <div class="w-24 h-24 bg-gradient-to-r from-f59e0b to-1a202c rounded-full flex items-center justify-center animate-scaleUp">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-amber-50 border-l-4 border-f59e0b p-4 mb-6 rounded-xl animate-fadeInUp" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-f59e0b rounded-xl flex items-center justify-center animate-scaleUp">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-amber-800 font-medium"><?php echo htmlspecialchars($_SESSION['success']);
                                                                unset($_SESSION['success']); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-xl animate-fadeInUp" role="alert">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 bg-red-500 rounded-xl flex items-center justify-center animate-scaleUp">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-800 font-medium"><?php echo htmlspecialchars($_SESSION['error']);
                                                            unset($_SESSION['error']); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Header Section -->
        <div class="card p-6 mb-6 animate-fadeInUp">
            <div class="border-l-4 border-f59e0b pl-4">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="mb-4 lg:mb-0">
                        <div class="flex items-center mb-2">
                            <div class="w-12 h-12 bg-f59e0b rounded-xl flex items-center justify-center mr-4 animate-scaleUp">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-1a2a44 font-sans">PRMSU Scheduling System</h1>
                                <?php if (isset($departmentName) && !empty($departmentName)): ?>
                                    <p class="text-f59e0b mt-1 font-medium font-sans">Department of <?php echo htmlspecialchars($departmentName); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="text-gray-600 font-sans">Welcome to your comprehensive scheduling dashboard.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="bg-gray-100 px-4 py-2 rounded-xl flex items-center hover:bg-gray-200 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2 text-f59e0b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 font-sans">
                                <?php echo htmlspecialchars($semesterInfo ?? 'Current Semester', ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                        <div class="bg-1a202c px-4 py-2 rounded-xl flex items-center hover:bg-4a5568 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-sm font-medium text-white font-sans">Active Term</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <?php
            $stats = [
                ['count' => $userCount ?? '0', 'label' => 'Total Users', 'link' => '/admin/users', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20a2 2 0 00-2-2v-4a2 2 0 00-2-2H9m-6 0V20h5a2 2 0 002 2h3a2 2 0 002-2v-4a2 2 0 00-2-2H9'],
                ['count' => $collegeCount ?? '0', 'label' => 'Total Colleges', 'link' => '/admin/colleges', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['count' => $departmentCount ?? '0', 'label' => 'Total Departments', 'link' => '/admin/colleges', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['count' => $facultyCount ?? '0', 'label' => 'Total Faculty', 'link' => '/admin/faculty', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['count' => $scheduleCount ?? '0', 'label' => 'Total Schedules', 'link' => '/admin/schedules', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z']
            ];
            foreach ($stats as $index => $stat): ?>
                <div class="card p-4 animate-fadeInUp" style="animation-delay: <?php echo $index * 0.1; ?>s">
                    <div class="flex items-center justify-between mb-3">
                        <div class="stat-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo $stat['icon']; ?>"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-gray-900 font-sans"><?php echo htmlspecialchars($stat['count'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p class="text-xs font-medium text-gray-600 uppercase font-sans"><?php echo $stat['label']; ?></p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="h-1 bg-f59e0b rounded-xl flex-1 mr-3"></div>
                        <a href="<?php echo $stat['link']; ?>" class="premium-button">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            View
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Semester Selection Form -->
        <div class="card p-6 mb-8 animate-fadeInUp">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-f59e0b rounded-xl flex items-center justify-center mr-4 animate-scaleUp">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 font-sans">Semester Configuration</h2>
                    <p class="text-gray-600 text-sm mt-1 font-sans">Set the current active academic semester</p>
                </div>
            </div>

            <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="semester_name" class="block text-sm font-medium text-gray-700 mb-2 font-sans">Semester</label>
                    <select id="semester_name" name="semester_name" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-f59e0b focus:border-f59e0b transition-all duration-200">
                        <option value="1st" <?php echo $currentSemester && $currentSemester['semester_name'] === '1st' ? 'selected' : ''; ?>>1st Semester</option>
                        <option value="2nd" <?php echo $currentSemester && $currentSemester['semester_name'] === '2nd' ? 'selected' : ''; ?>>2nd Semester</option>
                        <option value="Summer" <?php echo $currentSemester && $currentSemester['semester_name'] === 'Summer' ? 'selected' : ''; ?>>Mid Year</option>
                    </select>
                </div>

                <div>
                    <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-2 font-sans">Academic Year</label>
                    <input type="text" id="academic_year" name="academic_year" value="<?php echo htmlspecialchars($currentSemester['academic_year'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-f59e0b focus:border-f59e0b transition-all duration-200" placeholder="e.g., 2024-2025">
                </div>

                <div class="flex items-end">
                    <button type="submit" name="set_semester" class="premium-button animate-scaleUp">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Semester
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
            <!-- My Schedule Section -->
            <div class="xl:col-span-2">
                <div class="card h-full animate-fadeInUp">
                    <div class="px-6 py-4 border-b border-gray-200" style="border-color: #1a202c;">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <h3 class="text-xl font-semibold text-1a202c font-sans">My Schedule</h3>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-1a202c" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium font-sans"><?php echo htmlspecialchars($semesterInfo ?? '2nd Semester 2024-2025'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="schedule-table">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3">Course Name</th>
                                    <th class="px-4 py-3">Course Code</th>
                                    <th class="px-4 py-3">Section</th>
                                    <th class="px-4 py-3">Room</th>
                                    <th class="px-4 py-3">Day</th>
                                    <th class="px-4 py-3">Time</th>
                                    <th class="px-4 py-3">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($schedules) && !empty($schedules)): ?>
                                    <?php foreach ($schedules as $schedule): ?>
                                        <tr class="hover:bg-edf2f7 transition-colors duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 font-sans"><?php echo htmlspecialchars($schedule['course_name'] ?? 'N/A'); ?></div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-700 font-sans"><?php echo htmlspecialchars($schedule['course_code'] ?? 'N/A'); ?></div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-f59e0b/10 text-f59e0b rounded-full font-sans"><?php echo htmlspecialchars($schedule['section_name'] ?? 'N/A'); ?></span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-600 font-sans"><?php echo htmlspecialchars($schedule['room_name'] ?? 'TBD'); ?></div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 font-sans"><?php echo htmlspecialchars($schedule['day_of_week'] ?? 'N/A'); ?></div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-600 font-sans"><?php echo htmlspecialchars(($schedule['start_time'] ?? '') . ' - ' . ($schedule['end_time'] ?? '') ?: 'N/A'); ?></div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-1a202c/10 text-1a202c rounded-full font-sans"><?php echo htmlspecialchars($schedule['schedule_type'] ?? 'N/A'); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2 font-sans">No schedules found</h3>
                                                <p class="text-gray-500 text-center max-w-sm font-sans">No schedules found for this term.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50" style="border-color: #1a202c;">
                        <div class="flex justify-end">
                            <a href="/chair/my_schedule" class="premium-button animate-scaleUp">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                View Full Schedule
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Logs -->
            <div class="xl:col-span-1">
                <div class="card h-full flex flex-col animate-fadeInUp">
                    <div class="px-6 py-4 border-b border-gray-200 flex-shrink-0" style="border-color: #f59e0b;">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-f59e0b rounded-lg flex items-center justify-center mr-3 animate-scaleUp">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900 font-sans">Recent Activity</h2>
                            </div>
                        </div>
                    </div>

                    <div class="activity-logs-container flex-1 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Action</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden md:table-cell">Entity</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider hidden lg:table-cell">Description</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <?php
                                try {
                                    $stmt = $controller->db->prepare("
                                        SELECT al.log_id, al.action_type, al.action_description, al.entity_type, al.entity_id, 
                                               al.created_at, u.first_name, u.last_name
                                        FROM activity_logs al
                                        JOIN users u ON al.user_id = u.user_id
                                        ORDER BY al.created_at DESC
                                        LIMIT 5
                                    ");
                                    $stmt->execute();
                                    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    if (empty($logs)) {
                                        echo '<tr><td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <p class="text-gray-500 font-medium font-sans">No recent activity logs found</p>
                                                <p class="text-gray-400 text-sm mt-1 font-sans">Activity will appear here as users interact with the system</p>
                                            </div>
                                          </td></tr>';
                                    } else {
                                        foreach ($logs as $index => $log) {
                                            $bgClass = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                                            echo '<tr class="' . $bgClass . ' hover:bg-f59e0b/10 transition-colors duration-200">';

                                            echo '<td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="user-avatar mr-3">' . strtoupper(substr($log['first_name'], 0, 1)) . strtoupper(substr($log['last_name'], 0, 1)) . '</div>
                                                    <div class="text-sm font-medium text-gray-900 truncate max-w-24 font-sans">' . htmlspecialchars($log['first_name'] . ' ' . $log['last_name'], ENT_QUOTES, 'UTF-8') . '</div>
                                                </div>
                                              </td>';

                                            echo '<td class="px-4 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-f59e0b/20 text-f59e0b font-sans">
                                                    ' . htmlspecialchars($log['action_type'], ENT_QUOTES, 'UTF-8') . '
                                                </span>
                                              </td>';

                                            echo '<td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 font-sans hidden md:table-cell">' . htmlspecialchars($log['entity_type'] ?? 'N/A', ENT_QUOTES, 'UTF-8') . '</td>';

                                            echo '<td class="px-4 py-4 text-sm text-gray-600 max-w-xs truncate hidden lg:table-cell" title="' . htmlspecialchars($log['action_description'] ?? 'No description', ENT_QUOTES, 'UTF-8') . '" font-sans">' . htmlspecialchars($log['action_description'] ?? 'No description', ENT_QUOTES, 'UTF-8') . '</td>';

                                            echo '<td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 font-sans">
                                                <div class="text-sm font-medium text-gray-900">' . date('M d, Y', strtotime($log['created_at'])) . '</div>
                                                <div class="text-xs text-gray-500">' . date('H:i', strtotime($log['created_at'])) . '</div>
                                              </td>';

                                            echo '</tr>';
                                        }
                                    }
                                } catch (PDOException $e) {
                                    error_log("Activity logs error: " . $e->getMessage());
                                    echo '<tr><td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-red-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <p class="text-red-600 font-medium font-sans">Error loading activity logs</p>
                                            <p class="text-red-400 text-sm mt-1 font-sans">Please try refreshing the page or contact support</p>
                                        </div>
                                      </td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex-shrink-0" style="border-color: #f59e0b;">
                        <a href="/admin/act_logs" class="premium-button animate-scaleUp">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            View All Activity Logs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $content = ob_get_clean();
    require_once __DIR__ . '/layout.php';
    ?>