<?php
include_once './Config/database.php';
include_once './Entity\Client.php';
include_once './Repository\ClientRepository.php';
include_once './Entity/Commande.php';
include_once './Repository/CommandeRepository.php';
SystemMenu();
function SystemMenu()
{

    echo "\n";
    echo "╔═════════════════════════════════════════════════════════╗\n";
    echo "║     PAYMENT SYSTEM - MENU - CONSOLE APP                 ║\n";
    echo "╚═════════════════════════════════════════════════════════╝\n\n";
    echo "┌─────────────────────────────────────────────────────────┐\n";
    echo "│ MENU PRINCIPAL                                          │\n";
    echo "├─────────────────────────────────────────────────────────┤\n";
    echo "│ 1. Create a client                                      │\n";
    echo "│ 2. Create an order                                      │\n";
    echo "│ 3. Show the customer                                    │\n";
    echo "│ 4. Show the order                                       │\n";
    echo "│ 5. Cancel the order                                     │\n";
    echo "│ 6. Pay an order                                         │\n";
    echo "│ 7. Exit                                                 │\n";
    echo "└─────────────────────────────────────────────────────────┘\n";


    $choice = trim(readline("Your choice: "));
    ManageMenu($choice);
}

function ManageMenu($choice)
{
    $db = new DataBaseConnect();
    $ClientRepo = new ClientRepository($db);
    $CommandeRepo = new CommandeRepository($db);

    switch ($choice) {
        case "1":
            $name = trim(readline("Enter your name: "));

            $email = trim(readline("Enter your Email: "));

            try {
                $client = new Client($name, $email);
                $ClientRepo->addClient($client);
                echo "✅ Customer created successfully\n";
                SystemMenu();
            } catch (PDOException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            } catch (InvalidArgumentException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            }
            break;
        case "2":
            $clientName = trim(readline("Please Enter Customer name: "));
            $Clients = $ClientRepo->getClientsByName($clientName);

            try {
                foreach ($Clients as $client) {
                    echo "Client Id: " . $client->getId() . "\t\t";
                    echo "Name: " . $client->getName() . "\t\t";
                    echo "Email: " . $client->getEmail() . "\n";
                }

                $ClientId = trim(readline("Please enter customer Id: "));
                $total_amount = trim(readline("Please enter total amount: "));

                $Commande = new Commande($total_amount, $ClientId);
                $CommandeRepo->addCommande($Commande);

                SystemMenu();
            } catch (PDOException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            } catch (InvalidArgumentException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            }
            break;
        case "3":
            $Clients = $ClientRepo->getAllClients();
            try {
                foreach ($Clients as $client) {
                    echo "Client Id: " . $client->getId() . "\t\t";
                    echo "Name: " . $client->getName() . "\t\t";
                    echo "Email: " . $client->getEmail() . "\n";
                }
            } catch (PDOException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            } catch (InvalidArgumentException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            }
            break;
        case "4":
            $Commandes =  $CommandeRepo->getAllCommande();
            try {
                foreach ($Commandes as $Commande) {
                    echo "Commande Id: " . $Commande->getId() . "\t\t";
                    echo "Total amount: " . $Commande->getMontantTotal() . "\t\t";
                    echo "status: " . $Commande->getStatus() . "\n";
                }
            } catch (PDOException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            } catch (InvalidArgumentException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            }
            break;
        case "5":
            $clientName = trim(readline("Please Enter Customer name: "));
            $Clients = $ClientRepo->getAllClients($clientName);

            try {
                foreach ($Clients as $client) {
                    echo "Id: " . $client->getId() . "\t\t";
                    echo "Name: " . $client->getName() . "\t\t";
                    echo "Email: " . $client->getEmail() . "\n";
                }

                $ClientId = trim(readline("Please enter customer Id: "));
                $Commandes = $CommandeRepo->getCommandeById($ClientId);

                foreach ($Commandes as $Commande) {
                    echo "Id: " . $Commande->getId() . "\t\t";
                    echo "Total amount: " . $Commande->getMontantTotal() . "\t\t";
                    echo "status: " . $Commande->getStatus() . "\n";
                }

                $CommandeId = trim(readline("Please enter order Id: "));
                $CommandeRepo->CancelCommande($CommandeId);
            } catch (PDOException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            } catch (InvalidArgumentException $error) {
                echo "\n" . $error->getMessage() . "\n";
                SystemMenu();
            }
    }
}
