from collections import OrderedDict
from django.db.models.functions import ExtractYear, ExtractMonth

from django.db.models import Sum, Value
from django.db.models.functions import Coalesce


def summary_per_category(queryset):
    return OrderedDict(sorted(
        queryset
        .annotate(category_name=Coalesce('category__name', Value('-')))
        .order_by()
        .values('category_name')
        .annotate(s=Sum('amount'))
        .values_list('category_name', 's')
    ))


def total_per_year(queryset):
    return (
        queryset
        .annotate(year=ExtractYear('date'))
        .values('year')
        .annotate(total=Sum('amount'))
        .order_by('-year')
    )


def total_per_month(queryset):
    return (
        queryset
        .annotate(year=ExtractYear('date'), month=ExtractMonth('date'))
        .values('year', 'month')
        .annotate(total=Sum('amount'))
        .order_by('-year', '-month')
    )
