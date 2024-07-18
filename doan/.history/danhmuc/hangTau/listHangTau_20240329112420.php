<form>

    <div class="input-group">
        <input type="text" class="inputform-control" name="search_product_input"
            placeholder="Nhập tên sản phẩm cần tìm">
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </span>
        <a style="margin-left: 90px;" class="btn btn-outline-primary" onclick="loadContent('hangtau')">Thêm hãng tàu</a>
    </div>

</form>



<div class="table-responsive">
    <table class="table table-inverse table-bordered  table-hover ">
        <thead class="thead-dark">
            <tr>
                <th>STT</th>
                <th>Mã</th>
                <th>Tên hãng tàu</th>
                <th>Ngày tạo</th>
                <th>Người tạo</th>
                <th>Ngày sửa</th>
                <th>Người sửa</th>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody>

            <tr>
                <td>1</td>
                <td>EVG</td>
                <td>Evergreen</td>
                <td>2024-03-11 16:20:19</td>
                <td>Thảo</td>
                <td></td>
                <td></td>
                <td>
                
                    <a class="btn btn-info"  href="suaHangTau.php" >Sửa</a> 
                </td>
                <td>
                    <a class="btn btn-danger" href="delete.php?id=<?php echo $items['id']; ?> ">Xoá</a>

                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>ONE</td>
                <td>One</td>
                <td>2024-03-11 16:20:19</td>
                <td>Thảo</td>
                <td></td>
                <td></td>
                <td>
                
                    <a class="btn btn-info"  onclick="loadContent(" >Sửa</a> 
                </td>
                <td>
                    <a class="btn btn-danger" href="delete.php?id=<?php echo $items['id']; ?> ">Xoá</a>

                </td>
            </tr>

           

        </tbody>
    </table>
</div>