<?php
ob_start();
?>

<div class="max-w-7xl mx-auto p-6 bg-gradient-to-br from-gray-100 to-white min-h-screen">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-bold text-gray-800 animate-fadeIn tracking-tight">Manage Colleges & Departments</h1>
        <span class="text-yellow-600 bg-yellow-50 px-4 py-2 rounded-full text-sm font-semibold flex items-center shadow-sm">
            <i class="fas fa-user-shield mr-2"></i> AO admin 00
        </span>
    </div>

    <!-- Toast Notifications -->
    <?php if (isset($_SESSION['success'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('<?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?>', 'success');
            });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('<?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8'); ?>', 'error');
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="mb-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-10" aria-label="Tabs">
                <button id="college-tab" class="tab-button border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap py-4 px-2 border-b-2 font-semibold text-base active-tab transition-all duration-300" data-tab="college">
                    <i class="fas fa-graduation-cap mr-2"></i> Colleges
                </button>
                <button id="department-tab" class="tab-button border-transparent text-gray-600 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap py-4 px-2 border-b-2 font-semibold text-base transition-all duration-300" data-tab="department">
                    <i class="fas fa-building mr-2"></i> Departments
                </button>
            </nav>
        </div>
    </div>

    <!-- College Section -->
    <div id="college-content" class="tab-content animate-fadeIn">
        <!-- Create College Form -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8 transform transition-all duration-300 hover:shadow-lg border border-gray-100">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add New College</h2>
            <form action="/admin/colleges_departments/create" method="POST" class="space-y-6">
                <input type="hidden" name="type" value="college">
                <div>
                    <label for="college_name" class="block text-gray-700 font-medium mb-2">College Name <span class="text-xs text-gray-500">(e.g., Full name of the college)</span></label>
                    <input type="text" id="college_name" name="college_name" required class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-300 placeholder-gray-400 bg-white hover:bg-gray-50">
                </div>
                <div>
                    <label for="college_code" class="block text-gray-700 font-medium mb-2">College Code <span class="text-xs text-gray-500">(e.g., 3-4 letter abbreviation)</span></label>
                    <input type="text" id="college_code" name="college_code" required class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-300 placeholder-gray-400 bg-white hover:bg-gray-50">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-md">Create College</button>
            </form>
        </div>
        <!-- Colleges Table -->
        <div class="bg-white p-6 rounded-xl shadow-md transform transition-all duration-300 hover:shadow-lg border border-gray-100">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Colleges List</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-4 text-left text-gray-700 font-semibold border-b border-gray-200">Name</th>
                        <th class="p-4 text-left text-gray-700 font-semibold border-b border-gray-200">Code</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($colleges)): ?>
                        <tr>
                            <td colspan="2" class="p-4 text-center text-gray-500">No colleges found</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $colors = ['blue-600', 'green-600', 'purple-600', 'orange-600', 'teal-600'];
                        $collegeColors = [];
                        foreach ($colleges as $index => $college) {
                            $collegeColors[$college['college_id']] = $colors[$index % count($colors)];
                        }
                        ?>
                        <?php foreach ($colleges as $index => $college): ?>
                            <?php $color = $collegeColors[$college['college_id']]; ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-300 <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-gray-50'; ?>" style="border-left: 6px solid #<?php echo $color === 'blue-600' ? '2563eb' : ($color === 'green-600' ? '16a34a' : ($color === 'purple-600' ? '9333ea' : ($color === 'orange-600' ? 'ea580c' : '0d9488'))); ?>">
                                <td class="p-4 pl-6 flex items-center">
                                    <i class="fas fa-graduation-cap text-<?php echo $color; ?> mr-3"></i>
                                    <?php echo htmlspecialchars($college['college_name'], ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="p-4"><?php echo htmlspecialchars($college['college_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Department Section -->
    <div id="department-content" class="tab-content hidden animate-fadeIn">
        <!-- Create Department Form -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-8 transform transition-all duration-300 hover:shadow-lg border border-gray-100">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add New Department</h2>
            <form action="/admin/colleges_departments/create" method="POST" class="space-y-6">
                <input type="hidden" name="type" value="department">
                <div>
                    <label for="department_name" class="block text-gray-700 font-medium mb-2">Department Name <span class="text-xs text-gray-500">(e.g., Specific department name)</span></label>
                    <input type="text" id="department_name" name="department_name" required class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-300 placeholder-gray-400 bg-white hover:bg-gray-50">
                </div>
                <div>
                    <label for="college_id" class="block text-gray-700 font-medium mb-2">College <span class="text-xs text-gray-500">(Select the parent college)</span></label>
                    <select id="college_id" name="college_id" required class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all duration-300 bg-white hover:bg-gray-50">
                        <option value="" disabled selected>Select a college</option>
                        <?php foreach ($colleges as $college): ?>
                            <option value="<?php echo htmlspecialchars($college['college_id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <?php echo htmlspecialchars($college['college_name'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 shadow-md">Create Department</button>
            </form>
        </div>
        <!-- Departments Table -->
        <div class="bg-white p-6 rounded-xl shadow-md transform transition-all duration-300 hover:shadow-lg border border-gray-100">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Departments List</h2>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="p-4 text-left text-gray-700 font-semibold border-b border-gray-200">Name</th>
                        <th class="p-4 text-left text-gray-700 font-semibold border-b border-gray-200">College</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($departments)): ?>
                        <tr>
                            <td colspan="2" class="p-4 text-center text-gray-500">No departments found</td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $collegeColors = [];
                        foreach ($colleges as $index => $college) {
                            $collegeColors[$college['college_id']] = $colors[$index % count($colors)];
                        }
                        ?>
                        <?php foreach ($departments as $index => $department): ?>
                            <?php
                            $collegeId = $department['college_id'] ?? null;
                            $color = $collegeId && isset($collegeColors[$collegeId]) ? $collegeColors[$collegeId] : 'gray-500';
                            ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-300 <?php echo $index % 2 === 0 ? 'bg-white' : 'bg-gray-50'; ?>" style="border-left: 6px solid #<?php echo $color === 'blue-600' ? '2563eb' : ($color === 'green-600' ? '16a34a' : ($color === 'purple-600' ? '9333ea' : ($color === 'orange-600' ? 'ea580c' : '0d9488'))); ?>">
                                <td class="p-4 pl-6 flex items-center">
                                    <i class="fas fa-building text-<?php echo $color; ?> mr-3"></i>
                                    <?php echo htmlspecialchars($department['department_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td class="p-4"><?php echo htmlspecialchars($department['college_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.05);
    }
    input:focus, select:focus {
        outline: none;
        border-color: #2563eb;
    }
    table {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        overflow: hidden;
    }
    th {
        background-color: #f9fafb;
    }
    tr {
        transition: background-color 0.3s ease;
    }
    tr:hover {
        background-color: #f3f4f6;
    }
    td {
        border-bottom: 1px solid #e5e7eb;
    }
    input, select {
        transition: all 0.3s ease;
    }
    input:hover, select:hover {
        background-color: #f9fafb;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-blue-500', 'text-blue-600', 'active-tab');
                    btn.classList.add('border-transparent', 'text-gray-600');
                });
                tabContents.forEach(content => content.classList.add('hidden'));
                button.classList.add('border-blue-500', 'text-blue-600', 'active-tab');
                button.classList.remove('border-transparent', 'text-gray-600');
                document.getElementById(`${button.dataset.tab}-content`).classList.remove('hidden');
            });
        });
    });

    function showToast(message, type) {
        const container = document.createElement('div');
        container.className = `toast fixed top-5 right-5 p-4 rounded-xl text-white ${type === 'success' ? 'bg-green-600' : 'bg-red-600'} shadow-lg animate-slideIn transition-all duration-300`;
        container.textContent = message;
        document.getElementById('toast-container').appendChild(container);
        setTimeout(() => container.remove(), 3000);
    }
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/layout.php';
?>