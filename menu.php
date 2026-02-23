<?php
include "include/nav.php";
include "db/connect_db.php";

// Display menu items
$sql = "SELECT * FROM menu ORDER BY special DESC";
$result = $conn->query($sql);
?>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Menu Items</h1>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $vertical = $row['verticle_picture'] ?? '';
            $horizontal = $row['horozontial_picture'] ?? '';
            ?>

            <details class="card bg-base-100 shadow-lg mb-6 border border-gray-200  group transition-transform duration-300 ease-in-out hover:scale-105">
                <summary class="card-body list-none cursor-pointer ">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="card-title text-xl font-semibold">
                                <?php echo htmlspecialchars($row['item_name']); ?>
                            </h2>
                            <div class="text-gray-600 mt-1 space-x-4">
                                <span><strong>Price:</strong> $<?php echo $row['price']; ?></span>
                                <?php if ($row['special']): ?>
                                    <span class="text-red-500 font-bold">Special</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="text-4xl font-bold text-blue-600 transition-transform group-open:rotate-45">+</span>
                    </div>
                </summary>

                <div style="margin-left: 1rem; margin-right: 1rem;" class="mt-3 text-gray-700 border-t pt-4">
                    <p><strong>About:</strong></p>
                    <p class="mt-1"><?php echo htmlspecialchars($row['about']); ?></p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <?php if ($vertical): ?>
                            <img class="rounded-lg border" width="320" height="320"
                                 src="uploads/<?php echo htmlspecialchars($vertical); ?>"
                                 alt="Vertical Image">
                        <?php endif; ?>

                        <?php if ($horizontal): ?>
                            <img class="rounded-lg border" width="320" height="320"
                                 src="uploads/<?php echo htmlspecialchars($horizontal); ?>"
                                 alt="Horizontal Image">
                        <?php endif; ?>
                    </div>
                </div>
            </details>

        <?php }
    } else { ?>
        <p class="text-gray-500">No items yet.</p>
    <?php } ?>
</div>




<?php
include "include/footer.php";
?>