<?php
session_start();

// flash helpers
function set_flash($msg, $type = 'success') {
    $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
}
function get_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "tortoise_db");
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

// ---- Handle POST actions (Add or Delete) ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add note
    if (isset($_POST['tortoise_id']) && isset($_POST['note']) && !isset($_POST['delete_note'])) {
        $tortoiseID = (int)$_POST['tortoise_id'];
        $note = trim($_POST['note']);
        if ($tortoiseID > 0 && $note !== '') {
            $stmt = $conn->prepare("INSERT INTO researcher_notes (TortoiseID, Note) VALUES (?, ?)");
            if ($stmt) {
                $stmt->bind_param("is", $tortoiseID, $note);
                $stmt->execute();
                $stmt->close();
                set_flash("Note added successfully.", "success");
            } else {
                set_flash("DB error: " . $conn->error, "danger");
            }
        } else {
            set_flash("Please provide a valid tortoise and a note.", "warning");
        }
    }

    // Delete note (POST)
    if (isset($_POST['delete_note'])) {
        $noteID = (int)$_POST['delete_note'];
        if ($noteID > 0) {
            $stmt = $conn->prepare("DELETE FROM researcher_notes WHERE NoteID = ?");
            if ($stmt) {
                $stmt->bind_param("i", $noteID);
                $stmt->execute();
                $stmt->close();
                set_flash("Note deleted.", "success");
            } else {
                set_flash("DB error: " . $conn->error, "danger");
            }
        } else {
            set_flash("Invalid note id.", "warning");
        }
    }

    // Redirect back to avoid form resubmission and to keep URL clean
    $self = htmlspecialchars($_SERVER['PHP_SELF']);
    header("Location: {$self}");
    exit();
}

// ---- pagination ----
$limit = 10;
$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// fetch notes with tortoise info
$notes_sql = "SELECT rn.NoteID, rn.Note, rn.CreatedAt, t.ID AS TortoiseID, t.Name, t.Species
              FROM researcher_notes rn
              JOIN tortoise t ON rn.TortoiseID = t.ID
              ORDER BY rn.CreatedAt DESC
              LIMIT ? OFFSET ?";
$stmt = $conn->prepare($notes_sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$notes_res = $stmt->get_result();
$stmt->close();

// total notes count for pagination
$total_notes = 0;
$count_res = $conn->query("SELECT COUNT(*) AS cnt FROM researcher_notes");
if ($count_res) {
    $total_notes = (int)$count_res->fetch_assoc()['cnt'];
}
$total_pages = max(1, ceil($total_notes / $limit));

// fetch tortoises for dropdown (show Name but value = ID)
$tortoises = $conn->query("SELECT ID, Name FROM tortoise ORDER BY Name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Researcher Notes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body { background:#f4f6f9; }
    .sidebar {
      height:100vh; width:220px; position:fixed; top:0; left:0;
      background:#198754; color:#fff; padding-top:20px;
    }
    .sidebar a { color:#fff; text-decoration:none; padding:10px 20px; display:block; }
    .sidebar a:hover { background:#145c32; }
    .content { margin-left:240px; padding:20px; }
    .note-cell { max-width:420px; white-space:pre-wrap; word-wrap:break-word; }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Researcher</h4>
    <a href="/pages/researcher_dashboard.php">Dashboard</a>
    <a href="#" class="bg-secondary"><i class="bi bi-bug-fill"></i> Tortoise Data</a>
    <a href="/pages/researcher-breeding.php"><i class="bi bi-gender-ambiguous me-2"></i>Breeding</a>
    <a href="/pages/researcher-environment.php"><i class="bi bi-tree"></i> Environment</a>
    <a href="/pages/researcher-report.php"><i class="bi bi-file-earmark-text"></i> Reports</a>
    <a href="/index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>

  <div class="content">
    <h3>Researcher Notes</h3>

    <!-- flash -->
    <?php if ($flash = get_flash()): ?>
      <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>"><?= htmlspecialchars($flash['msg']) ?></div>
    <?php endif; ?>

    <!-- Add note form -->
    <div class="card mb-4">
      <div class="card-body">
        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
          <div class="row g-2">
            <div class="col-md-3">
              <label class="form-label">Select Tortoise</label>
              <select name="tortoise_id" class="form-select" required>
                <option value="">-- choose tortoise --</option>
                <?php if ($tortoises && $tortoises->num_rows): while ($t = $tortoises->fetch_assoc()): ?>
                  <option value="<?= (int)$t['ID'] ?>"><?= htmlspecialchars($t['Name']) ?></option>
                <?php endwhile; else: ?>
                  <option value="">No tortoises found</option>
                <?php endif; ?>
              </select>
            </div>

            <div class="col-md-7">
              <label class="form-label">Note</label>
              <input type="text" name="note" class="form-control" placeholder="Write a special research note..." required />
            </div>

            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" class="btn btn-success w-100" name="add_note">Add</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Notes table -->
    <div class="card">
      <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-success">
            <tr>
              <th>NoteID</th>
              <th>Tortoise</th>
              <th>Species</th>
              <th>Note</th>
              <th>CreatedAt</th>
              <th style="width:120px">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($notes_res && $notes_res->num_rows): ?>
              <?php while ($n = $notes_res->fetch_assoc()): ?>
                <tr>
                  <td><?= (int)$n['NoteID'] ?></td>
                  <td><?= htmlspecialchars($n['Name']) ?> (ID <?= (int)$n['TortoiseID'] ?>)</td>
                  <td><?= htmlspecialchars($n['Species']) ?></td>
                  <td class="note-cell"><?= nl2br(htmlspecialchars($n['Note'])) ?></td>
                  <td><?= htmlspecialchars($n['CreatedAt']) ?></td>
                  <td>
                    <!-- delete uses POST to be reliable -->
                    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" onsubmit="return confirm('Delete this note?');">
                      <input type="hidden" name="delete_note" value="<?= (int)$n['NoteID'] ?>" />
                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">No notes found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- pagination -->
        <nav>
          <ul class="pagination justify-content-center">
            <?php for ($i=1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// cleanup
if (isset($notes_res) && $notes_res instanceof mysqli_result) $notes_res->free();
$conn->close();
?>
