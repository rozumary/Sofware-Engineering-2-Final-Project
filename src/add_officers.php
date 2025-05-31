<?php
include './includes/config.inc.php';
include './functions.php';

show_header();
display_navbar();
display_sidebar();

$errors = [];
$success = '';

// --- Add your list of municipalities here ---
$municipalities = [
    "Cavinti",
    "Calauan",
    "Famy",
    "Kalayaan",
    "Lumban",
    "Liliw",
    "Luisiana",
    "Mabitac",
    "Magdalena",
    "Majayjay",
    "Paete",
    "Pagsanjan",
    "Pakil",
    "Pangil",
    "Pila",
    "Sta.Cruz",
    "Sta.Maria",
    "Siniloan",
    "Victoria"
];

// Handle Delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $officer_id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM officers WHERE officer_id = ?");
    if ($stmt->execute([$officer_id])) {
        $success = "Officer deleted successfully!";
    } else {
        $errors[] = "Failed to delete officer.";
    }
}

// Handle Edit
$edit_mode = false;
$edit_data = [
    'officer_id' => '',
    'name' => '',
    'email' => '',
    'mobile_number' => '',
    'position' => '',
    'municipality' => ''
];

if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $edit_mode = true;
    $officer_id = (int) $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM officers WHERE officer_id = ?");
    $stmt->execute([$officer_id]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC) ?: $edit_data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile_number = trim($_POST['mobile_number'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $municipality = trim($_POST['municipality'] ?? '');
    $officer_id = $_POST['officer_id'] ?? '';

    // Basic validation
    if (empty($name))
        $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors[] = "Valid email is required.";
    if (empty($mobile_number))
        $errors[] = "Mobile number is required.";
    if (empty($position))
        $errors[] = "Position is required.";
    if (empty($municipality))
        $errors[] = "Municipality is required.";

    if (empty($errors)) {
        if (!empty($officer_id)) {
            // Edit mode: update officer
            $stmt = $pdo->prepare("UPDATE officers SET name=?, email=?, mobile_number=?, position=?, municipality=? WHERE officer_id=?");
            if ($stmt->execute([$name, $email, $mobile_number, $position, $municipality, $officer_id])) {

                $stmt2 = $pdo->prepare("UPDATE area_assignment SET municipality=? WHERE officer_id=?");
                $stmt2->execute([$municipality, $officer_id]);

                $success = "Officer updated successfully!";
                $edit_mode = false;
            } else {
                $errors[] = "Database error. Please try again.";
            }
        } else {
            // Add mode: check for duplicate email
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM officers WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "An officer with this email already exists.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO officers (name, email, mobile_number, position, municipality) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$name, $email, $mobile_number, $position, $municipality])) {
                    $officer_id = $pdo->lastInsertId();
                    // Automatically assign the officer to the selected municipality in area_assignment
                    $stmt2 = $pdo->prepare("INSERT INTO area_assignment (officer_id, municipality) VALUES (?, ?)");
                    $stmt2->execute([$officer_id, $municipality]);
                    $success = "Officer added successfully!";
                } else {
                    $errors[] = "Database error. Please try again.";
                }
            }
        }
    }
    // Reset edit mode after POST
    if (empty($errors)) {
        $edit_mode = false;
        $edit_data = [
            'officer_id' => '',
            'name' => '',
            'email' => '',
            'mobile_number' => '',
            'position' => '',
            'municipality' => ''
        ];
        $_POST = [];
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="container py-2"> <!-- Added padding for spacing -->
            <div class="page-header">
                <h3 class="page-title"><?php echo $edit_mode ? 'Edit Officer' : 'Add Officer'; ?></h3>
            </div>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $e)
                        echo "<div>$e</div>"; ?>
                </div>
            <?php endif; ?>
            <form method="post" class="mt-3">
                <input type="hidden" name="officer_id"
                    value="<?php echo htmlspecialchars($edit_data['officer_id'] ?? ($_POST['officer_id'] ?? '')); ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required value="<?php
                    echo htmlspecialchars(
                        $edit_mode ? $edit_data['name'] : ($_POST['name'] ?? '')
                    );
                    ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="<?php
                    echo htmlspecialchars(
                        $edit_mode ? $edit_data['email'] : ($_POST['email'] ?? '')
                    );
                    ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mobile Number</label>
                    <input type="text" name="mobile_number" class="form-control" required value="<?php
                    echo htmlspecialchars(
                        $edit_mode ? $edit_data['mobile_number'] : ($_POST['mobile_number'] ?? '')
                    );
                    ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Position</label>
                    <input type="text" name="position" class="form-control" required value="<?php
                    echo htmlspecialchars(
                        $edit_mode ? $edit_data['position'] : ($_POST['position'] ?? '')
                    );
                    ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Municipality</label>
                    <select name="municipality" class="form-select" required>
                        <option value="" disabled <?php echo (empty($edit_mode ? $edit_data['municipality'] : ($_POST['municipality'] ?? ''))) ? 'selected' : ''; ?>>Select Municipality</option>
                        <?php foreach ($municipalities as $m): ?>
                            <option value="<?php echo htmlspecialchars($m); ?>" <?php
                               $selected = $edit_mode ? $edit_data['municipality'] : ($_POST['municipality'] ?? '');
                               if ($selected === $m)
                                   echo 'selected';
                               ?>>
                                <?php echo htmlspecialchars($m); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit"
                    class="btn btn-primary"><?php echo $edit_mode ? 'Update Officer' : 'Add Officer'; ?></button>
                <?php if ($edit_mode): ?>
                    <a href="add_officers.php" class="btn btn-secondary ms-2">Cancel</a>
                <?php endif; ?>
            </form>

            <hr>
            <h4>Officer List</h4>
            <div class="table-responsive">
                <table class="table table-bordered align-middle table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Position</th>
                            <th>Municipality</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT officer_id, name, email, mobile_number, position, municipality FROM officers ORDER BY officer_id DESC");
                        foreach ($stmt as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['mobile_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['position']); ?></td>
                                <td><?php echo htmlspecialchars($row['municipality']); ?></td>
                                <td>
                                    <a href="add_officers.php?edit=<?php echo $row['officer_id']; ?>"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <a href="add_officers.php?delete=<?php echo $row['officer_id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this officer?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php show_footer(); ?>
            </div>
        </div> <!-- /.container -->
    </div> <!-- /.content-wrapper -->
</div> <!-- /.main-panel -->