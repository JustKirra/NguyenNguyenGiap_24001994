const DongGioHang = {
  props: {
    item: { type: Object, required: true }
  },
  emits: ['doi-so-luong', 'yeu-cau-xoa'],
  computed: {
    thanhTien() {
      return this.item.donGia * this.item.soLuong;
    }
  },
  methods: {
    dinhDang(v) {
      return v.toLocaleString('vi-VN') + ' đồng';
    },
    tang() {
      this.$emit('doi-so-luong', this.item.id, this.item.soLuong + 1);
    },
    giam() {
      this.$emit('doi-so-luong', this.item.id, this.item.soLuong - 1);
    },
    xoa() {
      this.$emit('yeu-cau-xoa', this.item.id);
    }
  },
  template: `
    <tr>
      <td>{{ item.ten }}</td>
      <td>{{ dinhDang(item.donGia) }}</td>
      <td>
        <button :disabled="item.soLuong <= 1" @click="giam">-</button>
        <span class="sl">{{ item.soLuong }}</span>
        <button :disabled="item.soLuong >= 99" @click="tang">+</button>
      </td>
      <td>{{ dinhDang(thanhTien) }}</td>
      <td><button @click="xoa">Xóa</button></td>
    </tr>
  `
};