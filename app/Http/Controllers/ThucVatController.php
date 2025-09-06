<?php

namespace App\Http\Controllers;

use App\Services\ThucVatService;
use App\Services\BacChiService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ThucVatController extends Controller
{
    protected $thucVatService;
    protected $bacChiService;

    public function __construct(ThucVatService $thucVatService, BacChiService $bacChiService)
    {
        $this->thucVatService = $thucVatService;
        $this->bacChiService = $bacChiService;
    }

    public function index(): View
    {
        $thucVats = $this->thucVatService->getAll();
        $statistics = $this->thucVatService->getStatistics();

        return view('pages.thuc-vat.index', compact('thucVats', 'statistics'));
    }

    public function create(): View
    {
        $bacChis = $this->bacChiService->getAll();

        return view('pages.thuc-vat.create', compact('bacChis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bac_chi_id' => 'required|exists:bac_chi,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255',
            'ten_tac_gia' => 'nullable|string|max:255',
            'than_canh' => 'nullable|string',
            'la' => 'nullable|string',
            'phan_bo_viet_nam' => 'nullable|string',
            'phan_bo_the_gioi' => 'nullable|string',
            'hoa_qua' => 'nullable|string',
            'sinh_thai' => 'nullable|string',
            'dac_huu' => 'nullable|string|max:50',
            'gia_tri' => 'nullable|string',
            'sach_do' => 'nullable|string|max:50',
            'iucn' => 'nullable|string|max:50',
            'nd_84' => 'nullable|string|max:50',
            'nguon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            'bac_chi_id.required' => 'Chi không được để trống',
            'bac_chi_id.exists' => 'Chi không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự',
            'ten_tac_gia.max' => 'Tên tác giả không được vượt quá 255 ký tự',
            'dac_huu.max' => 'Đặc hữu không được vượt quá 50 ký tự',
            'sach_do.max' => 'Sách đỏ không được vượt quá 50 ký tự',
            'iucn.max' => 'IUCN không được vượt quá 50 ký tự',
            'nd_84.max' => 'NĐ 84 không được vượt quá 50 ký tự',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 5MB'
        ]);

        try {
            $thucVat = $this->thucVatService->create($request->all());
            if ($request->hasFile('images')) {
                $result = $this->thucVatService->addMultipleImages($thucVat->id, $request->file('images'));
                if (!$result['success']) {
                    $thucVat->delete();
                    return redirect()->back()->withInput()->with('err', $result['error']);
                }
            }
            return redirect()->route('thuc-vat.index')->with('success', 'Thêm thực vật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err', $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $thucVat = $this->thucVatService->findById($id);
        $images = $this->thucVatService->getImages($id);
        if (!$thucVat) {
            abort(404, 'Thực vật không tồn tại');
        }

        return view('pages.thuc-vat.show', compact('thucVat', 'images'));
    }

    public function edit(int $id): View
    {
        $thucVat = $this->thucVatService->findById($id);
        $bacChis = $this->bacChiService->getAll();

        if (!$thucVat) {
            abort(404, 'Thực vật không tồn tại');
        }

        // Load ảnh hiện có
        $images = $this->thucVatService->getImages($id);

        return view('pages.thuc-vat.edit', compact('thucVat', 'bacChis', 'images'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'bac_chi_id' => 'required|exists:bac_chi,id',
            'ten_khoa_hoc' => 'required|string|max:255',
            'ten_tieng_viet' => 'required|string|max:255',
            'ten_tac_gia' => 'nullable|string|max:255',
            'than_canh' => 'nullable|string',
            'la' => 'nullable|string',
            'phan_bo_viet_nam' => 'nullable|string',
            'phan_bo_the_gioi' => 'nullable|string',
            'hoa_qua' => 'nullable|string',
            'sinh_thai' => 'nullable|string',
            'dac_huu' => 'nullable|string|max:50',
            'gia_tri' => 'nullable|string',
            'sach_do' => 'nullable|string|max:50',
            'iucn' => 'nullable|string|max:50',
            'nd_84' => 'nullable|string|max:50',
            'nguon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ], [
            'bac_chi_id.required' => 'Chi không được để trống',
            'bac_chi_id.exists' => 'Chi không tồn tại',
            'ten_khoa_hoc.required' => 'Tên khoa học không được để trống',
            'ten_khoa_hoc.max' => 'Tên khoa học không được vượt quá 255 ký tự',
            'ten_tieng_viet.required' => 'Tên tiếng Việt không được để trống',
            'ten_tieng_viet.max' => 'Tên tiếng Việt không được vượt quá 255 ký tự',
            'ten_tac_gia.max' => 'Tên tác giả không được vượt quá 255 ký tự',
            'dac_huu.max' => 'Đặc hữu không được vượt quá 50 ký tự',
            'sach_do.max' => 'Sách đỏ không được vượt quá 50 ký tự',
            'iucn.max' => 'IUCN không được vượt quá 50 ký tự',
            'nd_84.max' => 'NĐ 84 không được vượt quá 50 ký tự',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 5MB'
        ]);

        try {
            $updated = $this->thucVatService->update($id, $request->all());

            if ($updated) {
                // Xử lý upload ảnh nếu có
                if ($request->hasFile('images')) {
                    $result = $this->thucVatService->addMultipleImages($id, $request->file('images'));
                    if (!$result['success']) {
                        throw new \Exception($result['error']);
                    }
                }

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Cập nhật thực vật thành công!',
                        'redirect' => route('thuc-vat.index')
                    ]);
                }

                return redirect()->route('thuc-vat.index')
                    ->with('success', 'Cập nhật thực vật thành công!');
            } else {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Thực vật không tồn tại!'
                    ], 400);
                }

                return redirect()->back()
                    ->withInput()
                    ->with('err', 'Thực vật không tồn tại!');
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }

            return redirect()->back()
                ->withInput()
                ->with('err', $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $deleted = $this->thucVatService->delete($id);

            if ($deleted) {
                return redirect()->route('thuc-vat.index')
                    ->with('success', 'Xóa thực vật thành công!');
            } else {
                return redirect()->route('thuc-vat.index')
                    ->with('err', 'Thực vật không tồn tại!');
            }
        } catch (\Exception $e) {
            return redirect()->route('thuc-vat.index')
                ->with('err', $e->getMessage());
        }
    }

    public function search(Request $request): View
    {
        $searchTerm = $request->get('search', '');
        $thucVats = collect();

        if (!empty($searchTerm)) {
            $thucVats = $this->thucVatService->searchByName($searchTerm);
        }

        return view('pages.thuc-vat.index', compact('thucVats', 'searchTerm'));
    }

    /**
     * Upload hình ảnh cho thực vật
     */
    public function uploadImage(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB
        ], [
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.image' => 'File phải là hình ảnh',
            'image.mimes' => 'Chỉ chấp nhận định dạng: JPEG, PNG, JPG, GIF, WEBP',
            'image.max' => 'Kích thước file tối đa 5MB'
        ]);

        $result = $this->thucVatService->addImage($id, $request->file('image'));

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Upload hình ảnh thành công!',
                'image' => $result['image'],
                'url' => $result['url'],
                'thumb_url' => $result['thumb_url']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 400);
    }

    /**
     * Upload hình ảnh từ file path
     */
    public function uploadImageFromPath(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'file_path' => 'required|string',
        ], [
            'file_path.required' => 'Đường dẫn file không được để trống'
        ]);

        $result = $this->thucVatService->addImageFromPath($id, $request->input('file_path'));

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Upload hình ảnh thành công!',
                'image' => $result['image'],
                'url' => $result['url'],
                'thumb_url' => $result['thumb_url']
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['error']
        ], 400);
    }

    public function deleteImage(int $imageId): RedirectResponse
    {
        $result = $this->thucVatService->deleteImage($imageId);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Xóa hình ảnh thành công!');
        }

        return redirect()->back()->with('err', $result['error']);
    }

    /**
     * Lấy danh sách hình ảnh
     */
    public function getImages(int $id): \Illuminate\Http\JsonResponse
    {
        $images = $this->thucVatService->getImages($id);

        return response()->json([
            'success' => true,
            'images' => $images
        ]);
    }
}
