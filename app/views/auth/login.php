<?php
$title = 'Login - Diary App';
include __DIR__ . '/../components/header.php';
?>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="glass rounded-xl p-8 neumorphism">
            <div class="text-center">
                <img src="/DiaryApp/logomydiary.png" alt="DiaryApp" style="width:84px;margin:0 auto 0.5rem;display:block;">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-1">Welcome Back</h2>
                <p class="text-sm text-gray-600">Sign in to your diary — your memories await</p>
            </div>
            <form class="mt-8 space-y-6" action="<?php echo APP_URL; ?>/auth/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset text-xs" placeholder="Enter your email">
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset text-xs" placeholder="Enter your password">
                            <button type="button" id="togglePassword" aria-label="Toggle password visibility" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">Show</button>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt"></i>
                        </span>
                        Sign In
                    </button>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-600">
                        Don't have an account?
                        <a href="/DiaryApp/register.php" class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors">Sign up</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword')?.addEventListener('click', function(){
    const pw = document.getElementById('password');
    if (!pw) return;
    if (pw.type === 'password') {
        pw.type = 'text';
        this.textContent = 'Hide';
    } else {
        pw.type = 'password';
        this.textContent = 'Show';
    }
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>