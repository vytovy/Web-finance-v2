<!DOCTYPE html>
<html>
<head>
    <title>Edit Reminder</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Edit Reminder</h1>
        <form method="POST" action="proses_reminder.php">
            <input type="hidden" name="id" value="<?= $data_reminder['id'] ?>">
            <div class="form-group">
                <label for="tanggal">Tanggal Janji</label>
                <input type="date" name="tanggal" value="<?= $data_reminder['tanggal_janji'] ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control"><?= $data_reminder['deskripsi'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="Belum Dikonfirmasi" <?= $data_reminder['status'] == 'Belum Dikonfirmasi' ? 'selected' : '' ?>>Belum Dikonfirmasi</option>
                    <option value="Dikonfirmasi" <?= $data_reminder['status'] == 'Dikonfirmasi' ? 'selected' : '' ?>>Dikonfirmasi</option>
                </select>
            </div>
            <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.