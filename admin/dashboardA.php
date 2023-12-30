<?php
include('../config.php');
include '../admin.php';
include '../statistic.php';
session_start(); 
$role=$_SESSION['user_role'];
$name=$_SESSION['nom_admin'];
$database = new Database('localhost', 'gestion_dataware', 'root', '');
$database->connect();
$pdo = $database->getPDO();

if ($role !== 'admin') {
  // Redirect to an unauthorized access page or show an error message
  header("Location: ../unauthorized.php");
  exit();
}
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  $logout=new ScrumMaster($pdo);
  $logout->logout();
}
$dashboard = new Dashboard($pdo);
$userCount = $dashboard->getCount('users', 'ID_User');
$productOwnerCount = $dashboard->getCountP('users', 'ID_User');
$scrumMasterCount = $dashboard->getCountS('users', 'ID_User');
$projectCount = $dashboard->getCount('projects', 'ProjectID');
$teamCount = $dashboard->getCount('teams', 'TeamID');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Document</title>
</head>
<body>
<div class="min-h-[640px] bg-gray-100 h">

  <div x-data="{ open: false }" @keydown.window.escape="open = false">
    

    <!-- Static sidebar for desktop -->
    <div id="sidebar" class="hidden fixed w-full md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
          <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-full w-full" src="../img/white.png" alt="Workflow">
          </div>
          <div class="flex-shrink-0 flex bg-gray-700 p-4 mt-4">
          <a href="#" class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
              <div>
                <img class="inline-block h-9 w-9 rounded-full" src="../img/moi.png" alt="profile">
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-white">
                <?php
                                if (isset($name)) {
                                    echo $name ;
                                } else {
                                    echo "Unknown nom";
                                }
                                ?>
                </p>
                <p class="text-xs font-medium text-gray-300 group-hover:text-gray-200">
                <?php
                                if (isset($role)) {
                                    echo $role;
                                } else {
                                    echo "Unknown Role";
                                }
                                ?>
                </p>
              </div>
            </div>
          </a>
        </div>
          <nav class="mt-5 flex-1 px-2 space-y-1">
            
              <a href="dashboardA.php" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-900 text-white&quot;, Default: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
                <svg class="text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;text-gray-300&quot;, Default: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/home" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
                Dashboard
              </a>
              <a href="users.php" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-900 text-white&quot;, undefined: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
              <svg class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state-description="undefined: &quot;text-gray-300&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M256 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96z"/></svg>
                Users
              </a>
              <a href="ajouterP.php" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-900 text-white&quot;, undefined: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
              <svg class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state-description="undefined: &quot;text-gray-300&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M256 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96z"/></svg>
                ADD User
              </a>
             
          </nav>
        </div>
        <div class=" flex  p-4">
           <a href="?action=logout" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-900 text-white&quot;, undefined: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
           <svg class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state-description="undefined: &quot;text-gray-300&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17,2H7C5.3,2,4,3.3,4,5v6h8.6l-2.3-2.3c-0.4-0.4-0.4-1,0-1.4c0.4-0.4,1-0.4,1.4,0l4,4c0.4,0.4,0.4,1,0,1.4c0,0,0,0,0,0l-4,4c-0.4,0.4-1,0.4-1.4,0c-0.4-0.4-0.4-1,0-1.4l2.3-2.3H4v6c0,1.7,1.3,3,3,3h10c1.7,0,3-1.3,3-3V5C20,3.3,18.7,2,17,2z"/></svg>
                Sign out
              </a>  
        </div>
      </div>
    </div>
    <div id="burgerMenu" class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-75 z-50 hidden md:hidden">
    <!-- Burger menu content -->
    <div class="flex justify-end p-4">
        <button id="closeBurgerMenu" class="text-white">&times;</button>
    </div>
    <div class="flex flex-col items-center mt-20">
        <a href="dashboardA.php" class="text-white text-xl py-2">Dashboard</a>
        <a href="ajouterP.php" class="text-white text-xl py-2">ADD users</a>
        <a href="users.php" class="text-white text-xl py-2">Users</a>
        <a href="?action=logout" class="text-white text-xl py-2">Sign out</a>
    </div>
</div>

<div class="md:pl-64 flex flex-col flex-1">
    <div class="sticky top-0 z-10 md:hidden pl-1 pt-1 sm:pl-3 sm:pt-3 bg-gray-100">
        <button id="burgerMenuButton" type="button" class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
      <main class="flex-1">
        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-4">
            <h1 class="text-2xl font-semibold text-gray-900">Welcome back       
                 <?php
                                if (isset($name )) {
                                    echo $name ;
                                } else {
                                    echo "Unknown nom";
                                }
                                ?></h1>
          </div>
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 flex  flex-wrap  justify-center gap-6">
            <!-- Replace with your content -->
     <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <!-- Number of Users Card -->
        <div class="bg-white p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-2">Number of Users</h2>
            <p class="text-3xl font-bold text-gray-800"><?= $userCount ?></p>
        </div>

        <!-- Number of Products Card -->
        <div class="bg-white p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-2">Number of ProductOwner</h2>
            <p class="text-3xl font-bold text-gray-800"><?= $productOwnerCount ?></p>
        </div>

        <!-- Number of Scrum Masters Card -->
        <div class="bg-white p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-2">Number of Scrum Masters</h2>
            <p class="text-3xl font-bold text-gray-800"><?= $scrumMasterCount ?></p>
        </div>

        <!-- Number of Projects Card -->
        <div class="bg-white p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-2">Number of Projects</h2>
            <p class="text-3xl font-bold text-gray-800"><?= $projectCount ?></p>
        </div>

        <!-- Number of Teams Card -->
        <div class="col-span-2 bg-white p-4 rounded-md shadow-md">
            <h2 class="text-xl font-semibold mb-2">Number of Teams</h2>
            <p class="text-3xl font-bold text-gray-800"><?= $teamCount ?></p>
        </div>
    </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  </div>
  <script>
      document.getElementById('burgerMenuButton').addEventListener('click', function () {
        document.getElementById('burgerMenu').classList.toggle('hidden');
    });

    document.getElementById('closeBurgerMenu').addEventListener('click', function () {
        document.getElementById('burgerMenu').classList.add('hidden');
    });
</script>
  </script>
</body>
</html>
