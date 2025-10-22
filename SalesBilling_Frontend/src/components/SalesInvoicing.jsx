import { useEffect, useState } from "react";
import { getAllSales, getInvoice } from "../api/services/salesServices";
import styles from "../styles/components/salesInvoicing.module.scss";

function SalesInvoicing() {
  const [sales, setSales] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchSales();
  }, []);

  const fetchSales = async () => {
    setLoading(true);
    try {
      const res = await getAllSales();
      const salesData = Array.isArray(res) ? res : res.data || [];
      setSales(salesData);
    } catch (err) {
      console.error(err);
      setSales([]);
    } finally {
      setLoading(false);
    }
  };

  const handleGenerateInvoice = async (saleId) => {
    try {
      const blob = await getInvoice(saleId);
      const url = window.URL.createObjectURL(
        new Blob([blob], { type: "application/pdf" })
      );
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("target", "_blank");
      link.setAttribute("download", `invoice-${saleId}.pdf`);
      document.body.appendChild(link);
      link.click();
      link.remove();
    } catch (err) {
      console.error("Error generating invoice:", err);
    }
  };

  return (
    <div className={styles.container}>
      <h2>Invoicing</h2>
      {loading ? (
        <p>Loading sales...</p>
      ) : sales.length === 0 ? (
        <p>No sales found.</p>
      ) : (
        <div className={styles.chartContainer}>
          <div className={styles.chartHeader}>
            <div>Sale #</div>
            <div>Date of Sale</div>
            <div>Invoice</div>
          </div>
          {sales.map((sale) => (
            <div key={sale.id} className={styles.chartRow}>
              <div>#{sale.id}</div>
              <div>
                {sale.created_at
                  ? new Date(sale.created_at).toLocaleString()
                  : "N/A"}
              </div>
              <div>
                <button onClick={() => handleGenerateInvoice(sale.id)}>
                  Generate Invoice
                </button>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

export default SalesInvoicing;
