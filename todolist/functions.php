<?php
function tampilkanDaftar(array $tasks): void {
    echo '<div class="table-responsive">';
    echo '<table class="table table-bordered table-hover align-middle">';
    echo '<thead class="table-light"><tr><th style="width:10%">Status</th><th>Judul</th><th style="width:25%">Aksi</th></tr></thead><tbody>';

    foreach ($tasks as $index => $task) {
        $checked = $task['status'] === 'selesai' ? 'checked' : '';
        $rowClass = $task['status'] === 'selesai' ? 'table-success' : '';
        $badgeClass = $task['status'] === 'selesai' ? 'badge-selesai' : 'badge-belum';
        $statusTeks = ucfirst($task['status']);
        $isEditing = isset($_POST['edit_index']) && $_POST['edit_index'] == $index;

        echo "<tr class='$rowClass'>";

        // Status checkbox + badge
        echo "<td>
                <form method='post'>
                    <input type='hidden' name='toggle_index' value='$index'>
                    <input type='checkbox' onchange='this.form.submit()' $checked>
                </form>
                <span class='badge mt-1 $badgeClass'>$statusTeks</span>
              </td>";

        // Judul atau Form Edit
        if ($isEditing) {
            echo "<td>
                    <form method='post' class='d-flex gap-2'>
                        <input type='hidden' name='save_edit_index' value='$index'>
                        <input type='text' name='edited_judul' value='" . htmlspecialchars($task['judul']) . "' class='form-control' required>
                        <button class='btn btn-success btn-sm'><i class='bi bi-check-lg'></i></button>
                    </form>
                  </td>";
        } else {
            echo "<td>" . htmlspecialchars($task['judul']) . "</td>";
        }

        // Aksi
        echo "<td>
                <div class='d-flex gap-2'>
                    <form method='post' class='d-inline'>
                        <input type='hidden' name='hapus_index' value='$index'>
                        <button class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus tugas ini?\")'>
                            <i class='bi bi-trash'></i> Hapus
                        </button>
                    </form>
                    <form method='post' class='d-inline'>
                        <input type='hidden' name='edit_index' value='$index'>
                        <button class='btn btn-warning btn-sm'>
                            <i class='bi bi-pencil'></i> Edit
                        </button>
                    </form>
                </div>
              </td>";

        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';
}
?>
