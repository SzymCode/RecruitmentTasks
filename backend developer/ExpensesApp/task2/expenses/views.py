from django.views.generic.list import ListView
from django.views.generic.edit import UpdateView
from django.db.models import Count, Sum

from .forms import ExpenseSearchForm
from .models import Expense, Category
from .reports import summary_per_category, total_per_year, total_per_month


class ExpenseListView(ListView):
    model = Expense
    paginate_by = 5

    def get_context_data(self, *, object_list=None, **kwargs):
        queryset = object_list if object_list is not None else self.object_list
        total_amount = 0

        form = ExpenseSearchForm(self.request.GET)
        if form.is_valid():
            name = form.cleaned_data.get('name', '').strip()
            date_from = form.cleaned_data.get('date_from', None)
            date_to = form.cleaned_data.get('date_to', None)
            categories = form.cleaned_data.get('categories', None)
            sort_by = form.cleaned_data.get('sort_by', None)
            sort_order = form.cleaned_data.get('sort_order', 'asc')

            if name:
                queryset = queryset.filter(name__icontains=name)
            if date_from:
                queryset = queryset.filter(date__gte=date_from)
            if date_to:
                queryset = queryset.filter(date__lte=date_to)
            if categories:
                queryset = queryset.filter(category__in=categories)
            if sort_by:
                if sort_order == 'desc':
                    sort_by = '-' + sort_by
                queryset = queryset.order_by(sort_by)

            total_amount = queryset.aggregate(Sum('amount'))['amount__sum'] or 0

        return super().get_context_data(
            form=form,
            object_list=queryset,
            total_amount=total_amount,
            summary_per_category=summary_per_category(queryset),
            total_per_year=total_per_year(queryset),
            total_per_month=total_per_month(queryset),
            **kwargs)


class CategoryListView(ListView):
    model = Category
    paginate_by = 5

    def get_queryset(self):
        queryset = super().get_queryset()
        queryset = queryset.annotate(expense_count=Count('expense'))
        return queryset


class CategoryUpdateView(UpdateView):
    model = Category
    fields = ['name']
