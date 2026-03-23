<form method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Nom de la salle" required>
    <input type="number" name="capacity" placeholder="Capacité" required>
    <input type="text" name="location" placeholder="Localisation">
    <textarea name="description" placeholder="Description"></textarea>
    <input type="file" name="image" accept="image/*"> <!-- Upload image -->
    <button type="submit">Créer</button>
</form>