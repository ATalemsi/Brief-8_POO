<?php
include '../config.php';
session_start();
global $pdo;
$role = $_SESSION['user_role'];
$name = $_SESSION['nom_admin'];
if ($role !== 'admin') {
  // Redirect to an unauthorized access page or show an error message
  header("Location: ../unauthorized.php");
  exit();
}
// SQL query to fetch users using prepared statement
$sql = "SELECT u.ID_User, u.Nom, u.Prenom, u.UserRole, t.TeamName AS TeaMN
FROM users u
LEFT JOIN teammembers tm ON u.ID_User = tm.UserID
LEFT JOIN teams t ON tm.TeamID = t.TeamID;";
$stmt = $pdo->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $pdo->errorInfo());
}

// Execute the statement
if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->errorInfo());
}

// Bind the result variables
$stmt->bindColumn('ID_User', $id);
$stmt->bindColumn('Nom', $Nom);
$stmt->bindColumn('Prenom', $Prenom);
$stmt->bindColumn('UserRole', $UserRole);
$stmt->bindColumn('TeaMN', $TeaMN);

// Fetch user data into an array
$users = [];
while ($stmt->fetch(PDO::FETCH_BOUND)) {
    $users[] = [
        'ID_User' => $id,
        'Nom' => $Nom,
        'Prenom' => $Prenom,
        'UserRole' => $UserRole,
        'TeaMN'=>$TeaMN,
        
    ];
}


$stmt->closeCursor();
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
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <div class="flex-1 flex flex-col min-h-0 bg-gray-800">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
          <div class="flex items-center flex-shrink-0 px-4">
            <img class="h-full w-full" src="../img/white.png" alt="Workflow">
          </div>
          <div class="flex-shrink-0 flex bg-gray-700 p-4 mt-4">
          <a href="#" class="flex-shrink-0 w-full group block">
            <div class="flex items-center">
              <div>
                <img class="inline-block h-9 w-9 rounded-full" src="../img/moi.jpg" alt="profile">
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
            
              <a href="dashboardA.php" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;bg-gray-900 text-white&quot;, Default: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
                <svg class="text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;text-gray-300&quot;, Default: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/home" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                  </svg>
                Dashboard
              </a>
              <a href="users.php" class="bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-900 text-white&quot;, undefined: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
              <svg  class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state-description="undefined: &quot;text-gray-300&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M186.3,129.9c13.9-10.6,23-27.4,23-46.2c0-32.1-26.1-58.2-58.2-58.2c-2.7,0-5.3,0.2-7.9,0.6c3.1,5.7,5.9,11.8,8.4,18.3c21.5,0.3,38.9,17.8,38.9,39.3c0,17.2-11.2,31.7-26.6,37c-0.2,7.5-0.7,14.9-1.6,22.1c36.6,5.4,64.8,37,64.8,75.1H246C246,178.1,221.3,144,186.3,129.9L186.3,129.9z M140,142.5c13.9-10.6,23-27.4,23-46.2c0-32.1-26.1-58.2-58.2-58.2c-32.1,0-58.2,26.1-58.2,58.2c0,18.8,9.1,35.6,23,46.2c-34.9,14-59.6,48.1-59.6,88h18.8c0-41.9,34.1-76,76-76c41.9,0,76,34.1,76,76h18.8C199.6,190.6,174.9,156.5,140,142.5L140,142.5z M104.8,56.9c21.7,0,39.3,17.7,39.3,39.3c0,21.7-17.7,39.3-39.3,39.3c-21.7,0-39.3-17.7-39.3-39.3C65.5,74.6,83.1,56.9,104.8,56.9L104.8,56.9z"/>
            </svg>
                Users
              </a>
              <a href="ajouterP.php" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-900 text-white&quot;, undefined: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
              <svg  class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" x-state-description="undefined: &quot;text-gray-300&quot;, undefined: &quot;text-gray-400 group-hover:text-gray-300&quot;" x-description="Heroicon name: outline/folder" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M186.3,129.9c13.9-10.6,23-27.4,23-46.2c0-32.1-26.1-58.2-58.2-58.2c-2.7,0-5.3,0.2-7.9,0.6c3.1,5.7,5.9,11.8,8.4,18.3c21.5,0.3,38.9,17.8,38.9,39.3c0,17.2-11.2,31.7-26.6,37c-0.2,7.5-0.7,14.9-1.6,22.1c36.6,5.4,64.8,37,64.8,75.1H246C246,178.1,221.3,144,186.3,129.9L186.3,129.9z M140,142.5c13.9-10.6,23-27.4,23-46.2c0-32.1-26.1-58.2-58.2-58.2c-32.1,0-58.2,26.1-58.2,58.2c0,18.8,9.1,35.6,23,46.2c-34.9,14-59.6,48.1-59.6,88h18.8c0-41.9,34.1-76,76-76c41.9,0,76,34.1,76,76h18.8C199.6,190.6,174.9,156.5,140,142.5L140,142.5z M104.8,56.9c21.7,0,39.3,17.7,39.3,39.3c0,21.7-17.7,39.3-39.3,39.3c-21.7,0-39.3-17.7-39.3-39.3C65.5,74.6,83.1,56.9,104.8,56.9L104.8,56.9z"/>
            </svg>
                 ADD User
              </a>
             
          </nav>
        </div>
        <div class=" flex  p-4">
           <a href="../logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md" x-state-description="undefined: &quot;bg-gray-900 text-white&quot;, undefined: &quot;text-gray-300 hover:bg-gray-700 hover:text-white&quot;">
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
        <a href="users.php" class="text-white text-xl py-2">Users</a>
        <a href="ajouterP.php" class="text-white text-xl py-2">ADD User</a>
        <a href="../logout.php" class="text-white text-xl py-2">Sign out</a>
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
                                ?>
            </h1>
          </div>
          <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 flex  flex-wrap  justify-center gap-6">
            <!-- Replace with your content -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 flex flex-wrap justify-center gap-6">
            <?php foreach ($users as $user): ?>
               <div class="relative flex flex-col text-gray-700 bg-white shadow-md w-80 rounded-xl bg-clip-border">
                 <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white h-80 rounded-xl bg-clip-border">
                     <img src="../img/moi.jpg" class="object-cover w-full h-full" />
                    </div>
                   <div class="p-6">
                         <div class="flex items-center justify-between mb-2">
                           <p class="block font-sans text-base antialiased font-medium leading-relaxed text-blue-gray-900"><?= $user['Nom'] . ' ' . $user['Prenom'] ?></p>
                           <p class="block font-sans text-base antialiased font-medium leading-relaxed text-blue-gray-900"><?= $user['UserRole'] ?></p>
                          </div>
                          <?php if (!empty($user['TeaMN'])): ?>
                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-700 opacity-75">
                                Equipe: <?= $user['TeaMN'] ?>
                            </p>
                        <?php else: ?>
                            <p class="block font-sans text-sm antialiased font-normal leading-normal text-gray-700 opacity-75">
                                Equipe: None
                            </p>
                        <?php endif; ?>
                      </div>
                      <div class="p-6 pt-0">
                           <a href="supprimer.php?id=<?= $user['ID_User'] ?>" class="block w-full select-none rounded-lg bg-rose-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white transition-all hover:scale-105 focus:scale-105 focus:opacity-[0.85] active:scale-100 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Supprimer</a>
                        </div>
                    <div class="p-6 pt-0">
                           <a href="modifier.php?id=<?= $user['ID_User'] ?>" class="block w-full select-none rounded-lg bg-blue-700 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white transition-all hover:scale-105 focus:scale-105 focus:opacity-[0.85] active:scale-100 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Modifier</a>
                    </div>
             </div>
      <?php endforeach; ?>
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
</body>
</html>