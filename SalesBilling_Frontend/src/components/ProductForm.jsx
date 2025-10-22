import { useState, useEffect } from "react";
import styles from "../styles/components/productForm.module.scss";
import { registerProduct } from "../api/services/productsService";
import { getAllCategories } from "../api/services/categoriesService";

function ProductForm() {
  const [formData, setFormData] = useState({
    code: "",
    name: "",
    description: "",
    unit: "",
    cost: "",
    price: "",
    stock: "",
    category: "",
  });

  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  // Fetch categories on mount
  useEffect(() => {
    const fetchCategories = async () => {
      try {
        const res = await getAllCategories();
        // Make sure we have an array
        const categoriesArray = Array.isArray(res) ? res : res.data || [];
        setCategories(categoriesArray);

        if (categoriesArray.length) {
          setFormData((prev) => ({
            ...prev,
            category: categoriesArray[0].name,
          }));
        }
      } catch (err) {
        setError(err?.message || "Failed to load categories");
      }
    };

    fetchCategories();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");
    setSuccess("");

    // Validate required fields
    if (!formData.code || !formData.name || !formData.category) {
      setError("Code, name and category are required");
      setLoading(false);
      return;
    }

    try {
      await registerProduct({
        ...formData,
        cost: parseFloat(formData.cost),
        price: parseFloat(formData.price),
        stock: parseInt(formData.stock),
      });
      setSuccess(`Product "${formData.name}" registered successfully!`);
      setFormData({
        code: "",
        name: "",
        description: "",
        unit: "",
        cost: "",
        price: "",
        stock: "",
        category: categories.length ? categories[0].name : "",
      });
    } catch (err) {
      setError(err?.message || "Failed to register product");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className={styles.formContainer}>
      <form className={styles.form} onSubmit={handleSubmit}>
        <h2 className={styles.title}>Register New Product</h2>

        {error && <p className={styles.error}>{error}</p>}
        {success && <p className={styles.success}>{success}</p>}

        <input
          type="text"
          name="code"
          placeholder="Product Code"
          value={formData.code}
          onChange={handleChange}
          required
        />

        <input
          type="text"
          name="name"
          placeholder="Product Name"
          value={formData.name}
          onChange={handleChange}
          required
        />

        <textarea
          name="description"
          placeholder="Description"
          value={formData.description}
          onChange={handleChange}
        />

        <input
          type="text"
          name="unit"
          placeholder="Unit (e.g., set, piece)"
          value={formData.unit}
          onChange={handleChange}
        />

        <input
          type="number"
          name="cost"
          placeholder="Cost"
          value={formData.cost}
          onChange={handleChange}
          step="0.01"
        />

        <input
          type="number"
          name="price"
          placeholder="Price"
          value={formData.price}
          onChange={handleChange}
          step="0.01"
        />

        <input
          type="number"
          name="stock"
          placeholder="Stock"
          value={formData.stock}
          onChange={handleChange}
        />

        <select
          name="category"
          value={formData.category}
          onChange={handleChange}
          className={styles.select}
        >
          {categories.map((cat) => (
            <option key={cat.id} value={cat.name}>
              {cat.name}
            </option>
          ))}
        </select>

        <button type="submit" disabled={loading}>
          {loading ? "Registering..." : "Register"}
        </button>
      </form>
    </div>
  );
}

export default ProductForm;
