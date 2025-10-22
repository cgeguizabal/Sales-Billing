import { useState } from "react";
import styles from "../styles/components/categoryForm.module.scss";
import { registerCategory } from "../api/services/categoriesService";

function CategoryForm() {
  const [categoryName, setCategoryName] = useState("");
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const handleChange = (e) => {
    setCategoryName(e.target.value);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");
    setSuccess("");

    if (!categoryName.trim()) {
      setError("Category name is required");
      setLoading(false);
      return;
    }

    try {
      await registerCategory({ name: categoryName });
      setSuccess(`Category "${categoryName}" created successfully!`);
      setCategoryName("");
    } catch (err) {
      setError(err?.message || "Failed to create category");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className={styles.formContainer}>
      <form className={styles.form} onSubmit={handleSubmit}>
        <h2 className={styles.title}>Register New Category</h2>

        {error && <p className={styles.error}>{error}</p>}
        {success && <p className={styles.success}>{success}</p>}

        <input
          type="text"
          name="name"
          placeholder="Category Name"
          value={categoryName}
          onChange={handleChange}
          required
        />

        <button type="submit" disabled={loading}>
          {loading ? "Registering..." : "Register"}
        </button>
      </form>
    </div>
  );
}

export default CategoryForm;
