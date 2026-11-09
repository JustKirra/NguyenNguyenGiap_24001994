const TheSanPham = {
  props: {
    ten: { type: String, required: true },          
    gia: { type: Number, required: true },
    anh: { type: String, default: 'https://placehold.co/300x180?text=No+image' }, 
    moTa: { type: String, default: 'Chưa có mô tả.' },
    tonKho: { type: Number, default: 0 }
  },
  data() {
    return { hienMoTa: false };
  },
  computed: {
    hetHang() {
      return this.tonKho <= 0;
    },
    giaDinhDang() {
      return this.gia.toLocaleString('vi-VN') + ' đ';
    }
  },
  methods: {
    batTatMoTa() {
      this.hienMoTa = !this.hienMoTa;
    },
    mua() {
      alert('Đã thêm "' + this.ten + '" vào giỏ hàng');
    }
  },
  template: `
    <div class="the">
      <img :src="anh" :alt="ten">
      <h3>{{ ten }}</h3>
      <p class="gia">{{ giaDinhDang }}</p>
      <p>
        Tồn kho: {{ tonKho }}
        <span v-if="hetHang" class="nhan-het">Hết hàng</span>
      </p>
      <button @click="batTatMoTa">{{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}</button>
      <button :disabled="hetHang" @click="mua">Mua</button>
      <p v-if="hienMoTa" class="mo-ta">{{ moTa }}</p>
    </div>
  `
};